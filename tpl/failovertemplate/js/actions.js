(function($){
	
	var Actions = function( ContainerSelector ) {
		try {
			
			this.Container = $( ContainerSelector );
			this.init();
			this.setHandlers();
			
		} catch ( e ) {}
	};
	
	
	Actions.prototype = {
		Container: false,
		init: function() {
			$.ajaxSetup({
				type: 'POST',
				url: '/failover_ajax/',
				dataType: 'json',
				error: function ( XMLHttpRequest, textStatus, errorThrown ) {}
			});
		},
		setHandlers: function() {
			var $this = this;
			
			this.Container.find( '.js-shutdown-button' ).click( function( event ) {
				event.preventDefault();
				
				$.ajax({
					data: {
						'action' : 'shutdown_master'
					},
					success: function( Response ) {
                        if ( typeof Response.status !== 'undefined' && Response.status == 'ok' ) {
							window.location.href = window.location.href;
                        }
                    }
				});
			});
			
			
			this.Container.find( '.js-refresh-page-button' ).click( function( event ) {
				event.preventDefault();
				
				window.location.href = window.location.href;
			});
			
			
			return false;
		}
	};
	
	
	$( document ).ready( function() {
		
		new Actions( '.js-failover-page' );
		
	});
	
})(jQuery)
