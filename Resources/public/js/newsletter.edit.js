var ns = ibrows_newsletter.namespace('ibrows_newsletter');

ns.edit = function($options){
    
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
             
        $self.setupNewBlockDialog();
        
        tinyMCE.init({
            mode : "specific_textareas",
            editor_selector: 'tinymce',
            theme : "advanced"
        });
    }
    
    this.setupNewBlockDialog = function(){
        $elements.newBlockDialogButton.click(function($event){
            $event.preventDefault();
            $self.openNewBlockDialog($event);
        });
        
        $elements.newBlockDialogAdd.click(function($event){
            $event.preventDefault();
            
            var $button = jQuery($event.srcElement);
            var $form = $button.closest('[data-element="new-block-dialog-provider-form"]');
            
            var $options = {};
            $form.find('[data-form-field="true"]').each(function(){
                var $formField = jQuery(this);
                $options[$formField.attr('name')] = $formField.val();
            });
            
            $self.addProviderBlock($elements.blocks, $options);
        });
        
        var buttons = {};
        buttons[$options.trans['newsletter.dialog.abort']] = function($event){
            $elements.newBlockDialog.dialog('close');
        };
        
        $elements.newBlockDialog.dialog({
            autoOpen: false,
            modal: true,
            buttons: buttons,
            width: '600',
            position: 'center'
        });
        
        $elements.newBlockDialogAccordion.accordion({
            heightStyle: 'content'
        });
    }
    
    this.openNewBlockDialog = function($event){
        var $dialog = $elements.newBlockDialog;
        $dialog.dialog('open');
    }
    
    this.closeNewBlockDialog = function($event){
        var $dialog = $elements.newBlockDialog;
        $dialog.dialog('close');
    }
    
    this.addProviderBlock = function($parent, $data){
        this.closeNewBlockDialog();
        jQuery.post(
            $options.url.addProviderBlock, 
            $data, 
            function($response){
                $parent.append($response.html);
            }
        );
    }
    
}