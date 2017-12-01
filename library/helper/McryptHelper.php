<?php
class McryptHelper {

    public static $key = "pcb_user_system";
    
    /**
     * 加密
     * @param type $str 需要加密的内容
     * @return type
     */
    public static function mcryptEncrypt($str) {
        //算法名称（cast-128 gost rijndael-128 twofish arcfour cast-256 loki97 rijndael-192 saferplus wake blowfish-compat des rijndael-256 serpent xtea blowfish enigma rc2 tripledes），算法地址，算法模版（cbc cfb ctr ecb ncfb nofb ofb stream），算法模版地址
        $td = mcrypt_module_open('tripledes', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
        $key = substr(md5(self::$key), 0, mcrypt_enc_get_key_size($td));
        mcrypt_generic_init($td, $key, $iv);
        $ret = base64_encode(mcrypt_generic($td, $str));
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $ret;
    }
    
    /**
     * 解密
     * @param type $value 需要解密的内容
     * @return type
     */
    public static function mcryptDencrypt($value){
        $td = mcrypt_module_open('tripledes', '', 'ecb', '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_URANDOM);
        $key = substr(md5(self::$key), 0, mcrypt_enc_get_key_size($td));
        mcrypt_generic_init($td, $key, $iv);
        $ret = trim(mdecrypt_generic($td, base64_decode($value))) ;
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        return $ret;
     }
}
    