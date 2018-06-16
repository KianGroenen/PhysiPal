$('a.edit').click(function () {
        var dad = $(this).parent().parent();
        dad.find('label').hide();
        var str = $.trim(dad.find('label').text());
        dad.find('input[type="text"]').val(str);
        dad.find('input[type="text"]').show().focus();
        dad.find('input[type="submit"]').show();
        dad.find('a.cancel').show();
        dad.find('a.delete').show();
    });

	$('a.cancel').click(function (){
		var dad = $(this).parent().parent();
		dad.find('input[type="text"]').hide()
        dad.find('input[type="submit"]').hide();
        dad.find('a.delete').hide();
        $(this).hide();
        dad.find('label').show();
	});