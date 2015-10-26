if (!RedactorPlugins) var RedactorPlugins = {};

(function($)
{
    $.Redactor.prototype.media = function()
    {
        return {
            init: function ()
            {
                var button = this.button.add('media', 'Media');
                this.button.addCallback(button, this.media.showAlert);

                // Set icon
                //this.button.setIcon(button, '<i class="glyphicon glyphicon-apple"></i>');
            },
            showAlert: function(buttonName)
            {
                $("#post-media-modal").modal("toggle");
            }
        };
    };
})(jQuery);