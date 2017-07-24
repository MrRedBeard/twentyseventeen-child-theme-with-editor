function x2bkgimgchange(val)
{
	if(val !== "" && val !== 'undefined')
	{
		Refresh_Image(val);
	}
	else
	{
		jQuery('#x2-preview-image').replaceWith( '<p id="x2-preview-image">No image defined</p>' );
	}
}
function x2RemoveBKGImage()
{
	jQuery('#x2_image_id').val('');
	x2bkgimgchange('');
}
	
jQuery(document).ready( function($) 
{
	//jQuery('x2-noimage')

	jQuery('input#x2_media_manager').click(function(e)
	{

		e.preventDefault();
		var image_frame;
		if(image_frame)
		{
		 image_frame.open();
		}
		// Define image_frame as wp.media object
		image_frame = wp.media({
				   title: 'Select Media',
				   multiple : false,
				   library : {
						type : 'image',
					}
			   });

			   image_frame.on('close',function()
			   {
				  // On close, get selections and save to the hidden input
				  // plus other AJAX stuff to refresh the image preview
				  var selection =  image_frame.state().get('selection');
				  var gallery_ids = new Array();
				  var my_index = 0;
				  selection.each(function(attachment) {
					 gallery_ids[my_index] = attachment['id'];
					 my_index++;
				  });
				  var ids = gallery_ids.join(",");
				  jQuery('input#x2_image_id').val(ids);
				  Refresh_Image(ids);
			   });

			  image_frame.on('open',function() 
			  {
				// On open, get the id from the hidden input
				// and select the appropiate images in the media manager
				var selection =  image_frame.state().get('selection');
				ids = jQuery('input#x2_image_id').val().split(',');
				ids.forEach(function(id) {
				  attachment = wp.media.attachment(id);
				  attachment.fetch();
				  selection.add( attachment ? [ attachment ] : [] );
				});

			  });

			image_frame.open();
	});

});


// Ajax request to refresh the image preview
function Refresh_Image(the_id)
{
        var data = {
            action: 'x2_get_image',
            id: the_id
        };
		
        jQuery.get(ajaxurl, data, function(response)
		{

            if(response.success === true)
			{
                jQuery('#x2-preview-image').replaceWith( response.data.image );
            }
        });
}
