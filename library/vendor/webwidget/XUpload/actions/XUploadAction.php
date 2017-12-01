<?php

/**
 * XUploadAction
 * =============
 * Basic upload functionality for an action used by the xupload extension.
 *
 * XUploadAction is used together with XUpload and XUploadForm to provide file upload funcionality to any application
 *
 * You must configure properties of XUploadAction to customize the folders of the uploaded files.
 *
 * Using XUploadAction involves the following steps:
 *
 * 1. Override CController::actions() and register an action of class XUploadAction with ID 'upload', and configure its
 * properties:
 * ~~~
 * [php]
 * class MyController extends CController
 * {
 *     public function actions()
 *     {
 *         return array(
 *             'upload'=>array(
 *                 'class'=>'xupload.actions.XUploadAction',
 *                 'path' =>Yii::app() -> getBasePath() . "/../uploads",
 *                 'publicPath' => Yii::app() -> getBaseUrl() . "/uploads",
 *                 'subfolderVar' => "parent_id",
 *             ),
 *         );
 *     }
 * }
 *
 * 2. In the form model, declare an attribute to store the uploaded file data, and declare the attribute to be validated
 * by the 'file' validator.
 * 3. In the controller view, insert a XUpload widget.
 *
 * ###Resources
 * - [xupload](http://www.yiiframework.com/extension/xupload)
 *
 * @version 0.3
 * @author Asgaroth (http://www.yiiframework.com/user/1883/)
 */
class XUploadAction extends CAction {

    /**
     * XUploadForm (or subclass of it) to be used.  Defaults to XUploadForm
     * @see XUploadAction::init()
     * @var string
     * @since 0.5
     */
    public $formClass = 'ext.webwidget.XUpload.models.XUploadForm';

    /**
     * Name of the model attribute referring to the uploaded file.
     * Defaults to 'file', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $fileAttribute = 'file';

    /**
     * Name of the model attribute used to store mimeType information.
     * Defaults to 'mime_type', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $mimeTypeAttribute = 'mime_type';

    /**
     * Name of the model attribute used to store file size.
     * Defaults to 'size', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $sizeAttribute = 'size';

    /**
     * Name of the model attribute used to store the file's display name.
     * Defaults to 'name', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $displayNameAttribute = 'name';

    /**
     * Name of the model attribute used to store the file filesystem name.
     * Defaults to 'filename', the default value in XUploadForm
     * @var string
     * @since 0.5
     */
    public $fileNameAttribute = 'filename';

    /**
     * The query string variable name where the subfolder name will be taken from.
     * If false, no subfolder will be used.
     * Defaults to null meaning the subfolder to be used will be the result of date("mdY").
     *
     * @see XUploadAction::init().
     * @var string
     * @since 0.2
     */
    public $subfolderVar;

    /**
     * Path of the main uploading folder.
     * @see XUploadAction::init()
     * @var string
     * @since 0.1
     */
    public $localPath;

    /**
     * Public path of the main uploading folder.
     * @see XUploadAction::init()
     * @var string
     * @since 0.1
     */
    public $publicPath;

    /**
     * @var boolean dictates whether to use sha1 to hash the file names
     * along with time and the user id to make it much harder for malicious users
     * to attempt to delete another user's file
     */
    public $secureFileNames = false;

    /**
     * Name of the state variable the file array is stored in
     * @see XUploadAction::init()
     * @var string
     * @since 0.5
     */
    public $stateVariable = 'XUploadFiles';

    /**
     * The form model we'll be saving our files to
     * @var CModel (or subclass)
     * @since 0.5
     */
    private $_formModel;

    /**
     * Initialize the propeties of pthis action, if they are not set.
     *
     * @since 0.1
     */
    public function init() {

        if (!isset($this->publicPath)) {
            $this->publicPath = UtilsHelper::uploadFolder();
        }

        if (!isset($this->localPath)) {
            $this->localPath = UtilsHelper::staticFolder($this->publicPath);
        }

        if (!isset($this->_formModel)) {
            $this->formModel = Yii::createComponent(array('class' => $this->formClass));
        }

        if ($this->secureFileNames) {
            $this->formModel->secureFileNames = true;
        }
    }

    /**
     * The main action that handles the file upload request.
     * @since 0.1
     * @author Asgaroth
     */
    public function run() {
        $this->sendHeaders();

        $this->handleDeleting() or $this->handleUploading();
    }

    protected function sendHeaders() {
        header('Vary: Accept');
        if (isset($_SERVER['HTTP_ACCEPT']) && (strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false)) {
            header('Content-type: application/json');
        } else {
            header('Content-type: text/plain');
        }
    }

    /**
     * Removes temporary file from its directory and from the session
     *
     * @return bool Whether deleting was meant by request
     */
    protected function handleDeleting() {
        if (isset($_GET["_method"])) {
            $success = false;
            if ($_GET["_method"] == "remove") {
                $success = true;
                $userFiles = Yii::app()->user->getState($this->stateVariable, array());
                if (isset($userFiles[$_GET["file"]]) && $this->fileExists($userFiles[$_GET["file"]])) {
                    unset($userFiles[$_GET["file"]]);
                    Yii::app()->user->setState($this->stateVariable, $userFiles);
                }
                //将数据从数据库中删除 
                if ($_GET['modelName'] && $_GET['id']) {
//                    $_GET['modelName']::model()->deleteByPk($_GET['id']);
                }
            } else if ($_GET["_method"] == "delete") {
                if ($_GET["file"][0] !== '.' && Yii::app()->user->hasState($this->stateVariable)) {
                    $userFiles = Yii::app()->user->getState($this->stateVariable, array());
                    if(isset($userFiles[$_GET["file"]])) {
                        if ($this->fileExists($userFiles[$_GET["file"]])) {
                            $success = $this->deleteFile($userFiles[$_GET["file"]]);
                        } else {
                            $success = true;
                        }
                    } else {
                        $fileName = $_GET["file"];
                        $file["url"] = "/upload/g/".substr($fileName, 0, 8)."/".$fileName;
                        $file["thumb"] = STATIC_URL.$file["url"];
                        if ($this->fileExists($file)) {
                            $success = $this->deleteFile($file);
                        } else {
                            $success = true;
                        }
                    }

                    if ($success) {
                        unset($userFiles[$_GET["file"]]);
                        Yii::app()->user->setState($this->stateVariable, $userFiles);
                    }
                }
            } else if ($_GET["_method"] == "setcover"){
                if ($_GET['modelName'] && $_GET['id'] && $_GET['goodsId']) {
                    $_GET['modelName']::model()->setCoverById($_GET['id'], $_GET['goodsId'], $_GET['vals']);
                    if($_GET['vals'] == 0){
                        $goodsimages = $_GET['modelName']::model()->findByPk($_GET['id']);
                        Goods::model()->updateByPk($_GET['goodsId'], array('logo' => $goodsimages['imgUrl']));
                    }
                    $success = true;
                }
            }

            echo json_encode($success);
            return true;
        }
        return false;
    }

    /**
     * Uploads file to temporary directory
     *
     * @throws CHttpException
     */
    protected function handleUploading() {
        $this->init();
        $model = $this->formModel;
        $model->{$this->fileAttribute} = CUploadedFile::getInstance($model, $this->fileAttribute);
        if ($model->{$this->fileAttribute} !== null) {
            $model->{$this->mimeTypeAttribute} = $model->{$this->fileAttribute}->getType();
            $model->{$this->sizeAttribute} = $model->{$this->fileAttribute}->getSize();
            $model->{$this->displayNameAttribute} = $model->{$this->fileAttribute}->getName();
            $model->{$this->fileNameAttribute} = $model->{$this->displayNameAttribute};

            if ($model->validate()) {

                $path = $this->getPath();

                if (!is_dir($path)) {
                    @mkdir($path, 0777, true);
                    @chmod($path, 0777);
                }

                $model->{$this->fileAttribute}->saveAs($path . $model->{$this->fileNameAttribute});
                @chmod($path . $model->{$this->fileNameAttribute}, 0777);
                $file = array(
                    "name" => $model->{$this->displayNameAttribute},
                    "filename" => $model->{$this->fileNameAttribute},
                    "url" => $model->getUrl($this->getPublicPath()),
                    "publicUrl" => $model->getPublicUrl($this->getPublicPath()),
                    "thumb" => $model->getThumb($this->getPublicPath()),
                    "publicThumb" => $model->getPublicThumb($this->getPublicPath()),
                    "type" => $model->{$this->mimeTypeAttribute},
                    "size" => $model->{$this->sizeAttribute},
                    "deleteUrl" => $this->getController()->createUrl($this->getId(), array(
                        "_method" => "delete",
                        "file" => $model->{$this->fileNameAttribute},
                    )),
                    "deleteType" => "GET",
                    "setcoverUrl" => $model->{$this->fileNameAttribute},
                );

                $returnValue = $this->beforeReturn($file);
                if ($returnValue === true || $returnValue === 'true') {
                    echo json_encode(array(
                        "files" => array($file),
                    ));
                } else {
                    echo json_encode(array("error" => $returnValue));
                    Yii::log("XUploadAction: " . $returnValue, CLogger::LEVEL_ERROR, "ext.XUpload.actions.XUploadAction");
                }
            } else {
                echo json_encode(array("error" => $model->getErrors($this->fileAttribute)));
                Yii::log("XUploadAction: " . CVarDumper::dumpAsString($model->getErrors()), CLogger::LEVEL_ERROR, "ext.XUpload.actions.XUploadAction");
            }
        } else {
            throw new CHttpException(500, "Could not upload file");
        }
    }

    /**
     * We store info in session to make sure we only delete files we intended to
     * Other code can override this though to do other things with state, thumbnail generation, etc.
     * @since 0.5
     * @author acorncom
     * @return boolean|string Returns a boolean unless there is an error, in which case it returns the error message
     */
    protected function beforeReturn($file) {
        // Now we need to save our file info to the user's session
        $userFiles = Yii::app()->user->getState($this->stateVariable, array());
        $userFiles[$this->formModel->{$this->fileNameAttribute}] = array(
            "name" => $file['name'],
            "filename" => $file['filename'],
            "is_save" => false,
            "url" => $file['url'],
            "publicUrl" => $file['publicUrl'],
            "thumb" => $file['thumb'],
            "publicThumb" => $file['publicThumb'],
        );

        Yii::app()->user->setState($this->stateVariable, $userFiles);

        return true;
    }

    /**
     * Returns the file's path on the filesystem
     * @return string
     */
    protected function getPath() {
        return $this->localPath;
    }

    /**
     * Returns the file's relative URL path
     * @return string
     */
    protected function getPublicPath() {
        return $this->publicPath;
    }

    /**
     * Deletes our file.
     * @param $file
     * @since 0.5
     * @return bool
     */
    protected function deleteFile($file) {
        return true;
        if (@unlink(UtilsHelper::staticFolder($file['url']))) {
            @unlink(UtilsHelper::staticFolder($file['thumb']));
            return true;
        }

        return false;
    }

    /**
     * Our form model setter.  Allows us to pass in a instantiated form model with options set
     * @param $model
     */
    public function setFormModel($model) {
        $this->_formModel = $model;
    }

    public function getFormModel() {
        return $this->_formModel;
    }

    /**
     * Allows file existence checking prior to deleting
     * @param $file
     * @return bool
     */
    protected function fileExists($file) {
        return is_file(UtilsHelper::staticFolder($file['url']));
    }

}
