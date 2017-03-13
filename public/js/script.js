$(document).ready(function () {

//Change tabs from view to add
    $('#tab1').click(function () {
        $(this).parent().addClass('active');
        $('#tab2').parent().removeClass('active');
        $('#portlet_comments_1').addClass('active');
        $('#portlet_comments_2').removeClass('active');
    });
    $('#tab2').click(function () {
        $(this).parent().addClass('active');
        $('#tab1').parent().removeClass('active');
        $('#portlet_comments_2').addClass('active');
        $('#portlet_comments_1').removeClass('active');
    });


//Change sub tabs, under add tab
    $('#sub_tab a').click(function () {
        var text = $(this).text();
        text = '#' + text + '-tab';
        $('.sub-tab .tab-pane').removeClass('active');
        $(text).addClass('active');
        $('#sub_tab li').removeClass('active');
        $(this).parent().addClass('active');
    });


//Family Tab

//Add family form
    $('#add-family-member').click(function () {
        var name = $('.mt-repeater-item .mt-repeater-input input').first().val();
        var date = $('.mt-repeater-item .mt-repeater-input input[type="date"]').first().val();
        var relation = $('.mt-repeater-item .mt-repeater-input select').first().val();
        if (relation != '? undefined:undefined ?' && name != '' && date != '') {
            $('.mt-repeater').last().append($('.mt-repeater-item').first().clone());
        }
    });

//Delete family form
    $(document).on("click", '.mt-repeater-delete', function () {

        var elem = $(this).parent().parent();
        var length = $('.mt-repeater-item').length;
        if (length != 1) {
            elem.remove();
        }
    });

//Image Tab
//Change Image Preview
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image-preview').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#uploaded-image").change(function () {
        readURL(this);
    });

//Remove Image button handler
    var file = $("#uploaded-image");

    $('#image-remove').click(function () {
        $('#image-preview').attr('src', "/avatars/image.jpg").val('');
        file.val('');
    });
//
//
//Information Tab
    $('#submit-form').click(function () {
        // if (file.val() == '') {
        //     $('.sub-tab .tab-pane').removeClass('active');
        //     $('#Image-tab').addClass('active');
        //     $('#sub_tab li').removeClass('active');
        //     $('#image-sub-tab').parent().addClass('active');
        // }
    });

//Export to PDF
    var doc = new jsPDF();

    $('#export-pdf').click(function () {
        doc.fromHTML($('#content').get(0), 15, 15, {
            'width': 170
        });
        doc.save('sample-file.pdf');
    });

});
