$( document ).ready(function() {
    var poll_count = $('#poll_count').val();
    if(poll_count != undefined && poll_count > 10){
        var totalPages = Math.ceil(poll_count / 10);
        $('#poll-pagination').twbsPagination({
            totalPages: totalPages,
            visiblePages: 4,
            initiateStartPageClick: false,
            onPageClick: function (event, page) {
                doLoadingDe();
                var offset = (page * 10) - 10;
                $.ajax({
                    url:'poll/ajax/'+offset,
                    dataType: 'JSON',  // what to expect back from the PHP script, if anything
                    cache: false,
                    type: 'get',

                    success: function(response){
                    removeLoadingDe()
                    if(response['status'] === false){
                        M.toast({html:response['message'],classes:'red-alert'});
                        return false;
                    }
                    $(".polls_cards").empty()
                        $(".polls_cards").html(response['data'])
                    },
                    error: function (xhr, status, error) {
                        removeLoadingDe()
                        M.toast({html:'Something Went Wrong While Getting Data',classes:'red-alert'});

                    }
                });

            }
        });
    }

    $('#expiry_datetime').flatpickr({
        enableTime:true,
        minDate: new Date(),
        dateFormat:'Y-m-d H:i:S',
    });

    if($('#expiry_datetime').val() != ''){
        M.updateTextFields();
    }
    $('.add_more_question').click(function (e) {
        e.preventDefault();
        var inputs = $(".answers").find($("input") );
        var count = inputs.length;
        if(count >= 4){
            M.toast({html:"Maximum Number Of Answers Is 4",classes:'red-alert'});
            return false;
        }
        $('.answers .row').append("<div class='input-field col s12'>\n" +
            "                                    <input type='text' id='option_"+count+"' id='question' name='options["+count+"]' required >\n" +
            "                                    <label for='option_"+count+"'>Answer "+(count + 1)+"</label>\n" +
            "                                </div>");
    });

    function removeLoadingDe() {
        setTimeout(function () {
            $('.loader-poll').fadeOut();
            window.scrollTo(0, 0);
        },500)
    }
    function doLoadingDe(){
        $('.loader-poll').fadeIn();
    }
    $('.modal').modal();
    window.pushIdToHref = function(id) {
        $('.modal-yes').attr('href','/admin/poll/destroy/'+id);
    }

});