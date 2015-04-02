jQuery(function ($) {

    var timepicker_options = {
        format: 'D MMMM YYYY HH:mm',
        sideBySide: true
    };

    $('#inputTime').datetimepicker(timepicker_options);

    var template_form = '\
        <form action="" method="post" class="form-inline">\
            <input type="hidden" name="_method" value="patch">\
            <input type="hidden" name="email" value="{email}">\
            <div class="form-group form-group-sm" style="position: relative">\
                <label class="sr-only">Sending time</label>\
                <input type="datetime" name="sending_time" class="form-control" value="{sending_time}" placeholder="Choose sending time" autocomplete="off" required>\
            </div>\
            <button type="reset" class="btn btn-default btn-sm">Cancel</button>\
            <button type="submit" class="btn btn-primary btn-sm">Edit</button>\
        </form>\
    ';

    $('.td-time').tooltip({
        placement: 'left',
        selector: '> a'
    }).on('click', '> a', function (e) {
        e.preventDefault();
        var anchor = $(this),
            time = anchor.text(),
            email = anchor.closest('tr').find('.td-email').text(),
            html = template_form.replace('{email}', email).replace('{sending_time}', time);
        anchor.hide();
        anchor.parent().append(html).find('[name="sending_time"]').datetimepicker(timepicker_options).focus();
    }).on('click', '[type="reset"]', function () {
        var td = $(this).closest('.td-time'),
            data = td.find('[name="sending_time"]').data("DateTimePicker");
        // Destroy calendar
        typeof data === 'object' && data !== null && data.hasOwnProperty('destroy') && data.destroy();
        td.children().not('a').remove();
        td.children('a').show();
    });

});
