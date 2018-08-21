jQuery(document).ready(function($){

	$.widget('metroskin.formbuilder',{

		options: {},

		formbuilder: {},

		_setOption: function(){
			
		},

		_create: function(){

			var that = this;
			var form_layout = $(this.bindings);

			$('#add_text').on('click',function(){
				that.createText(form_layout);
			})

			$('#add_textarea').on('click',function(){
				that.createTextarea(form_layout);
			})

			$('#add_checkbox').on('click',function(){
				that.createCheckbox(form_layout);
			})

			$('#add_radio').on('click',function(){
				that.createRadio(form_layout);
			})

			$('#add_switch').on('click',function(){
				that.createSwitch(form_layout);
			})

			$('#add_select').on('click',function(){
				that.createSelect(form_layout);
			})

			$('#add_file').on('click',function(){
				that.createFile(form_layout);
			})

			$('#add_button').on('click',function(){
				that.createButton(form_layout);
			})

			$('#add_header').on('click',function(){
				that.createHeader(form_layout);
			})






			form_layout.delegate('[data-form-builder],[data-form-builder] *','click',function(el){
				var element = $(el.toElement);
				var prop_html = '';

				$('#form_layout > div').removeClass('active_element');

				$(element).parents('.input-container').addClass('active_element');

				switch(element.data('form-builder')){
					case 'text':
						prop_html = that.getTextProperty(element);
					break;

					case 'textarea':
						prop_html = that.getTextareaProperty(element);
					break;

					case 'checkbox':
						prop_html = that.getCheckboxProperty(element);
					break;
					
					case 'radio':
						prop_html = that.getRadioProperty(element);
					break;
					
					case 'switch':
						prop_html = that.getSwitchProperty(element);
					break;
					
					case 'select':
						prop_html = that.getSelectProperty(element);
					break;

					case 'file':
						prop_html = that.getFileProperty(element);
					break;

					case 'button':
						prop_html = that.getButtonProperty(element);
					break

					case 'header':
						prop_html = that.getHeaderProperty(element);
					break

				}
				that.createPopover( element, prop_html );


			})


			$('body').delegate('[data-role="form_property_button"]','click',function(be){
				var button = $(be.toElement);

				var active_element = $('.active_element', form_layout);

				switch(button.data('action')){
					case 'save':
						that.saveToElement(active_element)
						that.destroyPopover()
					break;

					case 'remove':
						that.destroyElement(active_element);
						that.destroyPopover();
					break;
				}
			})

			$('#show_code').on('click',function(){
				$('#code_build').toggleClass('hide');
			})

			// zen input
			$('#zen_input').on('blur',function(){
				if(!$(this).val()){
					$('#zen_output').val('');
				}
				var html = HTML.query('#zen_area');
				html.innerHTML = '';
				html.add( $(this).val());
				$('#zen_output').val( html_beautify( $('#zen_area').html() ) );
			})


			// build code
			$('#build_code').on('click',function(){

				var b = $( form_layout ).html().replace(/^\s+/,'');

				$('*', $(b) ).removeAttr('html');

				t = $('<div/>').append(b).html();

				$('#text_code').val( html_beautify(t) );
				
			})


		},

		_destroy: function(){

		},

		// start custom function here
		
		createPopover: function(element, content){

			this.destroyPopover();
			var form_layout = $(this.bindings);

			content = content || '-- form property --';
			var popover = $( '<div id="formbuilder_property" class="popover marker-on-left bg-white shadow"><div></div></div>' );

			$(content).find('h4').addClass('fg-cyan');

			popover.html(content);
			popover.append( $('<div class="align-center"><button class="button small-button success" data-role="form_property_button" data-action="save">Save</button> <button class="button small-button alert" data-role="form_property_button" data-action="remove">Remove</button></div>'));
			popover.appendTo('body');
			popover.css('position','absolute');

            popover.css({
                top: element.offset().top + element.outerHeight()/2 - popover.outerHeight()/2 ,
                left: $(form_layout).offset().left + $(form_layout).outerWidth() - $(window).scrollLeft() + 5
            });
			
		},

		destroyPopover: function(){
			$('#formbuilder_property').fadeOut(function(){
				$(this).remove();
			});
		},

		saveToElement: function(element){
			var that        = this;
			var atts        = ['name','placeholder'];
			var value       = '';
			var form_prop = $('#formbuilder_property');
			var input_el    = '';
			var input_type  = '';

			if($('input',element).length){
				input_el   = $('input',element);
				input_type = 'input';

				if($(':file',element).length){
					input_type = 'file';
					input_el   = $(':file',element);
				}

			}else if($('textarea',element).length){
				input_el   = $('textarea',element);
				input_type = 'input';
			}else if( $('select',element).length){
				input_el   = $('select',element);
				input_type = 'select';
			}else if( $('button',element).length){
				input_el   = $('button',element);
				input_type = 'button';
			}else if( $('[data-form-builder="header"]',element).length){
				input_el   = $('[data-form-builder="header"]',element);
				input_type = 'header';
			}

			if(input_type!=='header'){
				$.each(atts , function(i,o){
					if(input_el.attr(o)){
						value = $('[name="'+o+'"]', form_prop).val();
						input_el.attr(o, value);
					}
				})
			}

			if( input_type == 'select'){
				
				if($('[name="type"]',form_prop).val()=='select2'){
					$('.input-control', element).attr('data-role','select');
				}else{
					$('.input-control', element).removeAttr('data-role');
				}

				$('select', element).html( $('[name="option"]').val());
			}

			if( input_type == 'button'){
				var btn_value = $('[name="value"]',form_prop).val().split(',');
				var btn_class = $('[name="class"]',form_prop).val().split(',');
				var btn_name  = $('[name="name"]',form_prop).val();

				$.each( input_el , function(i,o){
					$(input_el).eq(i).attr('value', btn_value[i].toLowerCase().replace(/\s+/,'_'));
					$(input_el).eq(i).attr('class', btn_class[i]);
					$(input_el).eq(i).attr('name', btn_name);
					$(input_el).eq(i).text( btn_value[i] )
				})

			}

			if( input_type == 'header'){
				var level   = $('[name="level"]',form_prop).val();
				var caption = $('[name="caption"]',form_prop).val();

				$(input_el).html(caption);
				$(input_el).attr('class','caption '+level);
				$(input_el).data('level',level);
			}

			if( input_type == 'input'){
				value = $('[name="value"]', form_prop).val();
				input_el.val( value );
			}

			caption = $('[name="caption"]', form_prop).val();
			$('.caption', element).html( caption );

			$.Notify({
				content:'Element Updated',
				caption:'Success',
				type:'success'
			});

		},

		destroyElement: function(element){
			if(confirm('Are you sure want to remove this element?')){
				$(element).slideUp(function(){
					$(this).remove();
				})
			}
		},


		createHeader: function(form_layout){
			var container = $('<div>').append('<div class="caption header" data-level="header" data-form-builder="header">Header</div>').addClass('input-container');
			$(container).appendTo( form_layout );
		},
		
		createText: function(form_layout){
			var container = $('<div>').append('<label class="caption">Text Input</label>').addClass('input-container');
			container.append( '<div class="input-control text full-size"><input type="text" data-form-builder="text" name="input_text" value="" /></div>' );

			$(container).appendTo( form_layout );
		},
		
		createTextarea: function(form_layout){
			var container = $('<div>').append('<label class="caption">Textarea</label>').addClass('input-container');
			container.append( '<div class="input-control textarea full-size"><textarea data-form-builder="textarea" name="input_textarea" ></textarea></div>' );

			$(container).appendTo( form_layout );
		},

		createCheckbox: function(form_layout){
			var container = $('<div>').append('<label class="input-control checkbox small-check"></label>').addClass('input-container');
			container.find('label').append('<input type="checkbox" name="checkbox" data-form-builder="checkbox" value="" /><span class="check"></span><span class="caption"> Checkbox</span>');

			$(container).appendTo( form_layout );
		},
		
		createRadio: function(form_layout){
			var container = $('<div>').append('<label class="input-control radio small-check"></label>').addClass('input-container');
			container.find('label').append('<input type="radio" name="radio" data-form-builder="radio" value="" /><span class="check"></span><span class="caption"> Radio</span>');

			$(container).appendTo( form_layout );
		},
		
		createSwitch: function(form_layout){
			var container = $('<div>').append('<label class="switch"></label>').addClass('input-container');
			container.find('label').append('<input type="checkbox" name="switch" data-form-builder="switch" value="" /><span class="check"></span><span class="caption"> Switch</span>');

			$(container).appendTo( form_layout );
		},

		createSelect: function(form_layout){
			var container = $('<div>').append('<label class="caption">Select</label>').addClass('input-container');
			container.append('<div class="input-control select full-size"><select name="select" data-form-builder="select"><option value="">-Select One-</option><option value="value">option</option><option value="value">option</option></select></div>');

			$(container).appendTo( form_layout );
		},

		createFile: function(form_layout){
			var container = $('<div>').append('<label class="caption">File</label>').addClass('input-container');
			container.append('<div class="input-control file full-size" data-role="input"><input type="file" name="file"/><button class="button" data-form-builder="file"><span class="mif-folder"></span></button></div>');

			$(container).appendTo( form_layout );
		},

		createButton: function(form_layout){
			var container = $('<div>').append('<button class="button caption info" name="submit" value="submit" data-form-builder="button">Submit</button> <button class="button caption " name="submit" value="apply" data-form-builder="button">Apply</button> <button class="button caption " name="submit" value="cancel" data-form-builder="button">Cancel</button> ').addClass('input-container');

			$(container).appendTo( form_layout );
		},

		
		getHeaderProperty: function(element){
			
			var el       = $(element);
			var prop     = $('<div>');
			var label    = '';
			var that     = this;
			var level    = {};

			level = {
				"leader":"h1",
				"sub-leader":"h2",
				"header":"h3",
				"sub-header":"h4",
				"sub-alt-header":"h5",
				"minor-header":"h6",
				"normal-div":"normal"
			}

			label = el.html();

			$(prop).append(this.propertySelect('Level',el.data('level'), level));

			$(prop).append(this.propertyInput('Caption',label));

			return ( '<h4 class="fg-cyan">Text property</h4>' + prop.html());
		},

		getTextProperty: function(element){
			
			var el    = $(element);
			var prop  = $('<div>');
			var atts  = ['name','placeholder'];
			var label = '';
			var that  = this;

			$(atts).each(function(i,o){
				if(el.attr(o)){
					$(prop).append( that.propertyInput( o, el.attr(o)));
				}
			})

			label = el.parent().prev().html();

			$(prop).append(this.propertyInput('Value',el.val()));

			$(prop).append(this.propertyInput('Caption',label));

			return ( '<h4 class="fg-cyan">Text property</h4>' + prop.html());
		},

		getTextareaProperty: function(element){
			var el    = $(element);
			var prop  = $('<div></div>');
			var atts  = ['name','placeholder'];
			var label = '';
			var that  = this;

			$(atts).each(function(i,o){
				if(el.attr(o)){
					$(prop).append( that.propertyInput( o, el.attr(o)));
				}
			})
			
			label = el.parent().prev().html();

			$(prop).append(this.propertyInput('Value',el.val()));

			$(prop).append(this.propertyInput('Caption',label));
			
			return ( '<h4 class="fg-cyan">Textarea property</h4>' + prop.html());

		},

		getCheckboxProperty: function(element){
			var el    = $(element);
			var prop  = $('<div></div>');
			var atts  = ['name','placeholder'];
			var label = '';
			var that  = this;

			$(atts).each(function(i,o){
				if(el.attr(o)){
					$(prop).append( that.propertyInput( o, el.attr(o)));
				}
			})
			
			label = el.next().next().html();

			$(prop).append(this.propertyInput('Value',el.val()));

			$(prop).append(this.propertyInput('Caption',label));
			
			return ( '<h4 class="fg-cyan">Checkbox property</h4>' + prop.html());

		},

		getRadioProperty: function(element){
			var el    = $(element);
			var prop  = $('<div></div>');
			var atts  = ['name','placeholder'];
			var label = '';
			var that  = this;

			$(atts).each(function(i,o){
				if(el.attr(o)){
					$(prop).append( that.propertyInput( o, el.attr(o)));
				}
			})
			
			label = el.next().next().html();

			$(prop).append(this.propertyInput('Value',el.val()));

			$(prop).append(this.propertyInput('Caption',label));
			
			return ( '<h4 class="fg-cyan">Radio property</h4>' + prop.html());

		},

		getSwitchProperty: function(element){
			var el    = $(element);
			var prop  = $('<div></div>');
			var atts  = ['name','placeholder'];
			var label = '';
			var that  = this;

			$(atts).each(function(i,o){
				if(el.attr(o)){
					$(prop).append( that.propertyInput( o, el.attr(o)));
				}
			})
			
			label = el.next().next().html();

			$(prop).append(this.propertyInput('Value',el.val()));

			$(prop).append(this.propertyInput('Caption',label));
			
			return ( '<h4 class="fg-cyan">Switch property</h4>' + prop.html());

		},

		getSelectProperty: function(element){
			var el      = $(element);
			var prop    = $('<div></div>');
			var atts    = ['name','placeholder'];
			var label   = '';
			var type    = '';
			var that    = this;
			var _option = '';

			$(atts).each(function(i,o){
				if(el.attr(o)){
					$(prop).append( that.propertyInput( o, el.attr(o)));
				}
			})
			
			label = el.parent().prev().html();

			type = (el.parent().data('role')=='select')?'select2':'select';

			type_rows = {'select':'Select','select2':'Select2'};

			_option = el.html();

			$(prop).append(this.propertySelect('Type', type, type_rows ));

			$(prop).append(this.propertyInput('Value',el.val()));

			$(prop).append(this.propertyInput('Caption',label));

			$(prop).append(this.propertyTextarea('Option', html_beautify( _option )));
			
			return ( '<h4 class="fg-cyan">Switch property</h4>' + prop.html());

		},

		getFileProperty: function(element){
			var el       = $(element);
			var prop     = $('<div></div>');
			var atts     = ['name','placeholder'];
			var label    = '';
			var that     = this;
			var input_el = {};

			input_el = el.prev().prev();

			$(atts).each(function(i,o){
				if(input_el.attr(o)){
					$(prop).append( that.propertyInput( o, input_el.attr(o)));
				}
			})
			
			label = el.parent().prev().html();

			$(prop).append(this.propertyInput('Caption',label));
			
			return ( '<h4 class="fg-cyan">File property</h4>' + prop.html());

		},

		getButtonProperty: function(element){

			var el       = $(element);
			var prop     = $('<div></div>');
			var _value   = [];
			var _class   = [];
			var that     = this;
			var input_el = {};

			input_el = element.parent().find('button');
			
			$.each(input_el, function(i,o){
				_value[i] = $(o).text();
				_class[i] = $(o).attr('class');
			})

			var tname  = $(input_el).eq(0).attr('name');
			var tvalue = _value.join(',');
			var tclass = _class.join(',');

			$(prop).append(this.propertyInput('Name', tname));
			$(prop).append(this.propertyInput('Value', tvalue));
			$(prop).append(this.propertyInput('Class', tclass));

			return ( '<h4 class="fg-cyan">Button property</h4>' + prop.html());

		},

		propertyInput: function(caption, value){
			return ('<div><label>'+caption+'</label><input type="text" class="input-control text full-size" name="'+caption.toLowerCase()+'" value="'+value+'" /></div>');
		},

		propertyTextarea: function(caption, value){
			return ('<div><label>'+caption+'</label><textarea class="input-control textarea full-size" rows="5" name="'+caption.toLowerCase()+'" >'+value+'"</textarea></div>');
		},

		propertySelect: function(caption, value, rows){
			var _select= $('<select name="'+caption.toLowerCase()+'"></select>');
			var _opt   = '';

			$.each( rows , function(i,o){
				_opt = '<option value="'+i+'" '+(i==value?'selected':'')+' >'+o+'</option>';
				$(_select).append( _opt );
			})

			return ('<div><label>'+caption+'</label><div class="input-control full-size select" >'+$('<div>').append(_select).html()+'</div></div>');
		}


	})



	$('#form_layout').formbuilder();

	$('#form_layout').sortable();

})
