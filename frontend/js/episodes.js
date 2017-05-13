$(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        // var form_data = $("#episode").serialize();
        // $.ajax(
        //     {
        //         type: 'POST',
        //         url: "/episode/new",
        //         data: form_data,
        //         success: function()
        //         {
        //             alert("Реєстраційні дані успішно відправлені");
        //         }
        //     }
        // );

        var controlForm = $(this).parents('.controls form:first'),
            currentEntry = $(this).parents('.entry:first'),
            newEntry = $(currentEntry.clone()).appendTo(controlForm);

        newEntry.find('input').val('');
        controlForm.find('.entry:not(:last) .btn-add')
            .removeClass('btn-add').addClass('btn-remove')
            .removeClass('btn-success').addClass('btn-danger')
            .html('<span class="glyphicon glyphicon-minus"></span> Удалить серию');
    }).on('click', '.btn-remove', function(e)
    {
        $(this).parents('.entry:first').remove();

        e.preventDefault();
        return false;
    });
});

