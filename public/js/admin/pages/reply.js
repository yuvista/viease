define(['jquery', 'underscore', 'admin/response-picker'], function ($, _, MediaResponsePicker) {
    new MediaResponsePicker('.response-media-picker', {current: {type:'text', text:'hello'}});
});