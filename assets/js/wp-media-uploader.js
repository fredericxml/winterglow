/*!
 * wpMediaUploader v1.0 2016-11-05
 * Copyright (c) 2016 Smartcat
 */
(function($) {
  'use strict';
  
  $.wpMediaUploader = function(options) {
    var settings = $.extend({
      target : '.smartcat-uploader', // The class wrapping the textbox
      uploaderTitle : 'Select or upload image', // The title of the media upload popup
      uploaderButton : 'Set image', // the text of the button in the media upload popup
      multiple : false, // Allow the user to select multiple images
      buttonClass : '.smartcat-upload', // the class of the upload button
      modal : false, // is the upload button within a bootstrap modal ?
    }, options);

    $('.smartcat-image').each(function() {
      const selector = $(this);
      if (selector.attr('src') !== '') {
        selector.css('display', 'block');
        selector.siblings('.smartcat-remove').show();
        selector.siblings('.smartcat-upload').text('Change image');
      }
    });
    
    $('body').on('click', settings.buttonClass, function(e) {
      e.preventDefault();
      var selector = $(this).parent(settings.target);
      var custom_uploader = wp.media({
        title: settings.uploaderTitle,
        button: { text: settings.uploaderButton },
        multiple: settings.multiple,
      })
      .on('select', function() {
        var attachment = custom_uploader.state().get('selection').first().toJSON();
        selector.find('img').attr('src', attachment.url).css('display', 'block');
        selector.find('#wing-smartcat-id').val(attachment.id);
        selector.find('#wing-smartcat-src').val(attachment.url);
        selector.find('#wing-smartcat-alt').val(attachment.alt);
        selector.find('.smartcat-remove').show();
        selector.find('.smartcat-upload').text('Change image');
        if (settings.modal) $('.modal').css('overflowY', 'auto');
      })
      .open();
    });
  
    $('body').on('click', '.smartcat-remove', function(e) {
      e.preventDefault();
      const selector = $(this);
      selector.hide();
      selector.siblings('input').val('');
      selector.siblings('.smartcat-image').hide();
      selector.siblings('.smartcat-upload').text('Upload image');
    });
  }

  $.wpMediaUploader();
})(jQuery);