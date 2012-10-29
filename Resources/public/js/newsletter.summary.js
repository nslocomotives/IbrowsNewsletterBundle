var ns = ibrows_newsletter.namespace('ibrows_newsletter');

ns.summary = function($options){

    var $self = this;
    var $options = $options;

    var $container = null;
    var $elements = {};

    this.ready = function(){
        $container = jQuery($options.container);

        for(var elemSelectorKey in $options.elements){
            var elemSelector = $options.elements[elemSelectorKey];
            $elements[elemSelectorKey] = $container.find(elemSelector);
        }

        this.resizeOverviewIframe();
    }

    this.resizeOverviewIframe = function(){
        $elements.overview.iframeAutoHeight();
    }
}