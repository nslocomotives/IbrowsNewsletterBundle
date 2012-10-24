var ns = ibrows_newsletter.namespace('ibrows_newsletter');

ns.newsletter = function($options){
    
    var $self = this;
    var $options = $options;
    
    this.ready = function(){
        jQuery('[data-ui-role="jquery-ui"]').button();
    }
    
}