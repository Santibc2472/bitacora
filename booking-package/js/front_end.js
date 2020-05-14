/**
if(typeof MutationObserver == 'function'){
	
    var user_observer = new MutationObserver(function(mutations){
		
        for(var key in mutations){
			
        }
	
    });

    var config = {
        attributes: true, 
        childList: false, 
        characterData: true, 
        subtree: true, 
        attributeFilter: ['class',  'style']
    };
    
    user_observer.observe(document.getElementById('booking-package'), config);
	
}
**/