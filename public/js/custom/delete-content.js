// Delete contact data
function deleteContent(url)
{
    $("#deleteForm").attr('action', url);
}

function formSubmit()
{
    $("#deleteForm").submit();
}
