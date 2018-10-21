function toggleCheckbox(element) {
    jQuery(document).ready(function($) {

        var data = {
            'action': 'my_action',
            'id': element.id,
            'value': element.value,
            'checked': element.checked
        };

        alert(JSON.stringify(data, null, 4));

        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(my_ajax_object.ajax_url, data, function(response) {
            response_json = JSON.parse(response);
            return response_json['result'];
        });
    });
}