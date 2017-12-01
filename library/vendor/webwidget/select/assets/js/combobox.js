(function( $ ) {
		$.widget( "ui.combobox", {
			_create: function() {
				var defaultText = this["options"].options.defaultText;
				var checkValue = this["options"].options.checkValue;
				var defaultExists = $(this.element).find("option[selected='selected']");
				if (defaultText !== "null") {
					if(defaultExists.length == 0) {
						$(this.element).prepend('<option value="" selected="selected">'+defaultText+'</option>');
					} else {
						$(this.element).prepend('<option value="">'+defaultText+'</option>');
					}
				} else {
					defaultText = this.element.children( ":selected" ).text();
				}
				
				var input,
					that = this,
					select = this.element.hide(),
					selected = select.children( ":selected" ),
//					value = selected.val() ? selected.text() : "",
					wrapper = this.wrapper = $("<span>").addClass("ui-combobox").insertAfter(select);
					if ($(this.element).find("option[selected='selected']").length > 0) {
						value = selected.val() ? selected.text() : "";
					} else {
						value = defaultText ? defaultText : selected.val() ? selected.text() : "";
					}

				function removeIfInvalid(element) {
					var value = $( element ).val(),
						matcher = new RegExp( "^" + $.ui.autocomplete.escapeRegex( value ) + "$", "i" ),
						valid = false;
					select.children( "option" ).each(function() {
						if ( $( this ).text().match( matcher ) ) {
							this.selected = valid = true;
							return false;
						}
					});
					if ( !valid ) {
						select.val();
						setTimeout(function() {
							input.tooltip( "close" ).attr( "title", "" );
						}, 2500 );
						input.data( "autocomplete" ).term = "";
						return false;
					}
				}
				var ulClass = comboboxUuid();
				input = $( "<input>" )
					.appendTo( wrapper )
					.val( value )
					.attr("title", "")
					.attr("name", this["options"].options.inputName)
					.autocomplete({
						delay: 0,
						minLength: 0,
						classes: ulClass,
						source: function( request, response ) {
							var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
							response( select.children( "option" ).map(function() {
								var text = $( this ).text();
								if ( this.value && ( !request.term || matcher.test(text) ) )							
									return {
										label: text.replace(
											new RegExp(
												"(?![^&;]+;)(?!<[^<>]*)(" +
												$.ui.autocomplete.escapeRegex(request.term) +
												")(?![^<>]*>)(?![^&;]+;)", "gi"
											), "<strong>$1</strong>" ),
										value: text,
										option: this
									};
							}) );
						},
						select: function( event, ui ) {
							ui.item.option.selected = true;
							that._trigger( "selected", event, {
								item: ui.item.option
							});
							checkInputColor($(ui.item.option).html());
						},
						change: function( event, ui ) {
							if ( !ui.item && checkValue )
							{
								this.value = selected.text();
								return removeIfInvalid( this );
							}
						}
					}).click(function(){
						input.val("");
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							removeIfInvalid( input );
							return;
						}

						input.autocomplete( "search", "" );
						input.focus();
					}).blur(function(){
						if (!input.val()) {
							//取消选择
							select.children(":selected").removeProp("selected");
						}
						checkInputColor(input.val());
					})

				zindex = 99;
				if(this["options"].options.zindex != undefined) {
					zindex = this["options"].options.zindex;
				}
				input.data( "autocomplete" )._renderItem = function( ul, item ) {
					ul.css("z-index", zindex);
					return $( "<li>" )
						.data( "item.autocomplete", item )
						.append( "<a>" + item.label + "</a>" )
						.appendTo( ul );
				};

				$( "<a>" )
					.attr( "tabIndex", -1 )
					.tooltip()
					.appendTo( wrapper )
					.button({
						icons: {
							primary: "ui-icon-triangle-1-s"
						},
						text: false
					})
					.removeClass( "ui-corner-all" )
					.addClass( "ui-corner-right ui-combobox-toggle" )
					.click(function() {
						if ( input.autocomplete( "widget" ).is( ":visible" ) ) {
							input.autocomplete( "close" );
							removeIfInvalid( input );
							return;
						}

						$( this ).blur();

						input.autocomplete( "search", "" );
						input.focus();
					});

					input
						.tooltip({
							position: {
								of: this.button
							},
							tooltipClass: "ui-state-highlight"
						});
					
				//change input color by different value
				function checkInputColor(inputValue) {
					if((inputValue == "" || inputValue == defaultText) && select.find("option").length > 0) {
						input.val(defaultText);
						//input.css({"color":"#c1c4c8"});
					} else {
						//input.css({"color":"#333333"});
					}
				}
				
				//dynamic add css class
				function addStyle(properties) {
					var style;
					if(document.all) {
						style = document.createStyleSheet();  
				        style.cssText = properties; 
					} else {
						style = document.createElement("style");   
				        style.type = "text/css";
				        style.textContent = properties;
					}
					try{
						document.getElementsByTagName("head")[0].appendChild(style);
					} catch(e){}
				}
				
				//keyboard operate
				function _move(operate, ulId) {
					var allA = $("#"+ulId).find(".ui-corner-all");
					var index = allA.index($("#"+ulId).find(".ui-corner-all[class*='"+ulId+"']").eq(0));
					allA.removeClass(ulId);
					if(operate == "prev" || operate == "next") {
						operate == "prev" ? index = index - 1 : index = parseInt(index + 1);
						allA.eq(index).addClass(ulId);
					} else {
						eval("allA."+operate+"().addClass('"+ulId+"')");
					}
				}
				
				//generate uuid class
				function comboboxUuid() {
					var id = "class_"+new Date().getTime()+"_"+parseInt(Math.random()*(100-1)+1);
					if ($("."+id).length != 0) {
						comboboxUuid();
					}
					return id;
				}
				
				//init customize parameters
				function customizeParam(args) {
					var width = "368";
					var height = "28";
					var hovercolor = "#379fef";
					if(args.options.width != undefined) {
						width = args.options.width;
					}
					if(args.options.height != undefined) {
						height = args.options.height;
					}
					if(args.options.hovercolor != undefined) {
						hovercolor = args.options.hovercolor;
					}
					if(args.options.defaults != undefined && args.options.defaults && defaultExists.length == 0) {
						$.each($(select).find("option"), function(k,v){
							if($(v).text() == defaultText) {
								$(v).remove();
								option = $(select).find("option").eq(0); 
								option.attr("selected", "selected");
								input.val(option.text());
							}
						})
					}
					if(args.options.inputValue) {
						input.val(args.options.inputValue);
					}
					
					//获取下拉列表ul的ID
					var div = $(select).next();
					var ulIndex = $("."+ulClass).attr("id");
					addStyle("."+ulIndex+"{background-color:"+hovercolor+";color:#fff !important;}");
					
					div.css({
						"width":width,
						"height":height
					});
					if(args.options.extClass != undefined) {
						div.addClass(args.options.extClass);
					}
					div.find(".ui-autocomplete-input").css({
						"width": width - 10,
						"height":height,
						"line-height":height + "px"
					}).bind("keydown", function(event){
						switch ( event.keyCode ) {
							case $.ui.keyCode.UP:
								_move("prev", ulIndex);
							break;
							case $.ui.keyCode.DOWN:
								_move("next", ulIndex);
							break;
							case $.ui.keyCode.HOME:
								_move("first", ulIndex);
								break;
							case $.ui.keyCode.END:
								_move("last", ulIndex);
								break;
							case $.ui.keyCode.PAGE_UP:
								_move("first", ulIndex);
								break;
							case $.ui.keyCode.PAGE_DOWN:
								_move("last", ulIndex);
								break;
						}
					});
					$("#" + ulIndex).delegate("a", "mouseover", function(){
						$(this).addClass(ulIndex);
					}).delegate("a", "mouseout", function(){
						$(this).removeClass(ulIndex);
					})
				}
				
				wrapper.wrap("<div class='selectPluginRadius'></div>");
				customizeParam(this["options"]);
			},

			destroy: function() {
				this.wrapper.remove();
				this.element.show();
				$.Widget.prototype.destroy.call( this );
			}
		});
	})( jQuery );