$(function() {
    $('#add_img, #edit_img').click(function(e){
		$(this).parent().parent().find('input[type=file]').click();
	})
	
    $('#del_img').click(function(e){
                $('.preview_field img').attr('src', '/admin/images/no-preview-big.jpg');
                $('#preview_file_name').text('');
                $('#preview_fiels').val('');
                $('.preview_field input').val('');
                $('#add_img').show();
                $('#edit_img').hide();
                $('#del_img').hide();        
    })    
    
    $('.preview_field input').change(function(e){

                var file = this.files[0];
				var aImg = $('.preview_field img');
				var reader = new FileReader();
				reader.onload = (function(aImg) {
					return function(e) {
						aImg.attr('src', e.target.result);
					};
				})(aImg);
					
				reader.readAsDataURL(file);
                $('#preview_file_name').text(file.name);
                $('#add_img').hide();
                $('#edit_img').show();
                $('#del_img').show();

	})
});