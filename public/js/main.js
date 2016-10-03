function unhide(id) {
    $('#'+id).removeClass('hidden');
}

function hide(id) {
    $('#'+id).addClass('hidden');
}

function hideSendMail()
{ 
    if ($('#recipient-mailing').is(':checked')) {
        hide('mail-visibility');
        hide('mail-to');
    } 
    
    if($('#recipient-other').is(':checked')) {
        unhide('mail-visibility');
        unhide('mail-to');
    }
}