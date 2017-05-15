$(function()
{
    var serial_id =  $('input[name=serial_id]').attr('value');
    $(document).ready(function(){
        $.ajax({
            url: "/episode/" + serial_id,
            cache: false,
            success: function(html){
                $("#episodecontent").html(html);
            }
        });
        return false;
    });

    $(document)
        .on('click', '.btn-add', function(e)
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
                        url: "/episode/new/" + serial_id,
                        data: form_data,
                        success: function(response)
                        {
                            $.ajax({
                                url: "/episode/" + serial_id,
                                cache: false,
                                success: function(html){
                                    $("#episodecontent").html(html);
                                }
                            });
                        }
                    }
                );

                $(this).parents('.entry').find('input').val('');

            })
        .on('click', '.btn-danger', function()
            {
                var id = $(this).attr('id');
                $.ajax(
                    {
                        type: 'GET',
                        url: "/episode/delete/" + id,
                        success: function(response)
                        {
                            $.ajax({
                                url: "/episode/" + serial_id,
                                cache: false,
                                success: function(html){
                                    $("#episodecontent").html(html);
                                }
                            });
                        }
                    });
                return false;
            });
});

