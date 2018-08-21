
var su_button_debug = null;

jQuery(document).ready(function($){

	register_tabs_cmd({
		button_class : 'view-item',
		tabs_title : 'view',
		content_id : 'view_item',
		ref_action : 'show',
		close_class : 'close-view'
	})

	register_tabs_cmd({
		button_class : 'edit-item',
		tabs_title : 'edit',
		content_id : 'edit_item',
		ref_action : 'edit',
		close_class : 'close-edit'
	})

	register_tabs_cmd({
		button_class : 'create-item',
		tabs_title : 'create',
		content_id : 'create_item',
		ref_action : 'create',
		close_class : 'close-create'
	})


	$('body').delegate('.save-item','click',function(e){
		e.preventDefault();
		$('#edit_item').append('<div id="info_ajax" ></div>')
		var tform = $(this).data('form');
		var that = $(this);

		$.Notify({
		  content: 'processing...',
		  type: 'info',
		  shadow: true
		})

		if(su_button_debug==1){
			$(tform).submit();
		}

		$(tform).find('.errorMessage').remove();

		$(tform).ajaxSubmit({
			// target:'#info_ajax',
			dataType: 'JSON',
			success: function(data){
				if(data.result==1){

			        $.Notify({
			          content: 'Data Saved',
			          type: 'success',
			          shadow: true
			        })

			        var targetTable = $(that).data('table');
			        var formAction = $(targetTable).attr('action');
			        var postData = {_method:'POST'};

			        // $(targetTable).submit();
			        
			        // refresh table list
			        $(targetTable).ajaxSubmit({
			        	type: 'GET',
			        	url: formAction, 
			        	// data: postData, 
			        	success: function(data){
			        		// console.log(targetTable);
			        		$(targetTable).html(data);
					        $('.close-edit,.close-create').trigger('click');

    			        }
    			    })

				}else{

					$.Notify({
					  content: data.message ,
					  type: 'alert',
					  shadow: true
					})

					type_1 = ['text','textarea','password','file'];

					if( Object.keys(data.fields).length > 0){
						$.each(data.fields, function(i,o){
							var tobj = $(tform).find('[name="' + i + '"]');
							if( type_1.indexOf( $(tobj).attr('type')) >= 0 ){
								$(tobj).addClass('errorHelper');
								htm_msg = o.join(',');
								// console.log(htm_msg);
								$(tobj).after('<div class="errorMessage" >' + htm_msg + '</div>');
							}
						})
					}

				}

			}
		});

	})


	$('body').delegate('.delete-item','click',function(e){
		e.preventDefault();
		if(!confirm('Are you sure want to delete this item ?')){
			return false;
		}
		var that = this;
		var refto = $(this).parents('form').data('ref');

		$.ajax({
			url: refto + '/'+$(this).data('id') ,
			type: 'DELETE',
			success: function(data){
				console.log(data)
				if(data.result){
					$.Notify({
					  content: data.message ,
					  type: 'info',
					  shadow: true
					})
					$(that).parents('tr').hide(200, function(){
						$(this).remove();
					})
				}
			}
		})
	})

	
	$('body').delegate('.link-box .pagination > li > a','click',function(e){
		e.preventDefault();
		var p = $(this).parents('.link-box');
		var target = p.data('target');
		var url = $(this).attr('href');
		$.get(url, function(data){
			$(target).html(data);
		})	
	})

	$('body').delegate('.errorHelper','click',function(e){
		$(this).removeClass('errorHelper');
		$(this).next().remove();
	})

	$('.metro-logout').click(function(e){
		e.preventDefault();
		if(confirm($(this).data('confirm'))){
			$('#logout-form').submit();
		}
	})


});


/*
	eg:
    register_tabs_cmd({
		button_class : 'edit-item',
		tabs_title : 'edit',
		content_id : 'edit_item',
		ref_action : 'edit',
		close_class : 'close-edit'
    })
 */
function register_tabs_cmd( options ) {
    // code here 
    var opts = $.extend( {
    	button_class : '', // class of button
        tabs_title : '',   // title on tabs
        content_id : '',   // content id w/o #
        ref_action : '',   // edit, create, etc...
        close_class : '',
        target_list : ''
    }, options );	

    // create tabs
	$('body').delegate( '.' + opts.button_class ,'click',function(e){

		e.preventDefault();
		if($('.page-tab > .tabs a[href="#' + opts.content_id + '"]').length < 1){
			var frame_content = '';
			var id = $(this).data('id');
			var refto = $(this).parents('form').data('ref');

			$(this).parents('table').find('tr').removeClass('selected');
			$(this).parents('tr').addClass('selected');	

			$.Notify({
			  content: 'Loading content ...',
			  type: 'success',
			  shadow: true
			})

			// push data into frame
			$.get( refto + '/' + opts.ref_action + '/' + id,function(data){
				frame_content = data;

				htm_li = '<li><a href="#' + opts.content_id + '" >' + opts.tabs_title + ' </a></li>';
				htm_frame = '<div id="' + opts.content_id + '" >' + frame_content + '</div>';
				
				$('.page-tab > .tabs').append(htm_li);
				$('.page-tab > .frames').append(htm_frame);

				$('.page-tab > .tabs a[href="#' + opts.content_id + '"]').trigger('click');
			})

		}else{
			$.Notify({
			  content: 'Another instance of ' + opts.tabs_title + ' tab is open',
			  type: 'info',
			  shadow: true
			})
		}
	})

	// close tab
	$('body').delegate('.' + opts.close_class , 'click', function(e){
		e.preventDefault();
		var refto = $(this).data('ref');
		console.log(opts.content_id);
		$('#'+ opts.content_id).remove();
		$('a[href="#' + opts.content_id + '"]').parent('li').remove();
		$('a[href="#'+refto+'_list"]').trigger('click');
	})

};


/*
	register button save event

	register_save_button({
		button_class : 'save-item',
		close_class : 'close-edit'
		form_target : '#form_edit'
	})

	<button class="button button-small button-primary save-group" >Save</button>


 */
function register_save_button(options){

    var opts = $.extend( {
    	button_class : '', // class of button          : save-item
    	source_form : '' , // form target              : #form_edit
    	target_table : '', // table target             : #userTable
        close_class : '.close-edit,.close-create'   // : .close-edit
    }, options );	


	$('body').delegate('.' + opts.button_class ,'click',function(e){
		e.preventDefault();
		// $('#' + opts.content_id ).append('<div id="info_ajax" ></div>')
		var tform = opts.source_form;
		var that = $(this);

		$.Notify({
		  content: 'processing...',
		  type: 'info',
		  shadow: true
		})

		if(su_button_debug==1){
			$(tform).submit();
		}

		$(tform).ajaxSubmit({
			// target:'#info_ajax',
			dataType: 'JSON',
			success: function(data){
				if(data.result==1){

			        $.Notify({
			          content: 'Data Saved',
			          type: 'success',
			          shadow: true
			        })

			        var targetTable = opts.target_table;
			        var formAction = $(targetTable).attr('action');
			        // var postData = {_method:'POST'};

			        // $(targetTable).submit();
			        
			        // refresh table list
			        $(targetTable).ajaxSubmit({
			        	type: 'GET',
			        	url: formAction, 
			        	// data: postData, 
			        	success: function(data){
			        		// console.log(targetTable);
			        		$(targetTable).html(data);
					        $( '.' + opts.close_class ).trigger('click');

    			        }
    			    })

				}else{

					$.Notify({
					  content: data.message ,
					  type: 'alert',
					  shadow: true
					})

				}

			}
		});

	})

}

