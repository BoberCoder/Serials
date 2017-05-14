$(function()
{
    $(document).on('click', '.btn-add', function(e)
    {
        e.preventDefault();

        if($("#title").val()==="")
        {
            alert("Введите название!");
            return false;
        }
        else if($("#description").val()==="")
        {
            alert("Введите описание!");
            return false;
        }

        var form_data = $("#episode").serialize();
        $.ajax(
            {
                type: 'POST',
                url: "/episode/new",
                data: form_data,
                success: function(response)
                {
                    alert("Серия добавлена");
                }
            }
        );

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

