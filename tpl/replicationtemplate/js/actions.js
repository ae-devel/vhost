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
				url: '/replication_ajax/',
				dataType: 'json',
				error: function ( XMLHttpRequest, textStatus, errorThrown ) {}
			});
		},
		setHandlers: function() {
			var $this = this;
			
			this.Container.find( '.js-insert-code-button' ).click( function( event ) {
				event.preventDefault();
				
				$.ajax({
					data: {
						'action' : 'insert_code'
					},
					success: function( Response ) {
                        if ( typeof Response.data !== 'undefined' ) {
							var Html = '';
							
							for( var i in Response.data ) {
								Html += '<div class="g-mb10">' + Response.data[ i ][ 'id' ] + ' | ' + Response.data[ i ][ 'row_time' ] + ' | ' + Response.data[ i ][ 'row_code' ] + '</div>'
							}
                            $this.Container.find( '.js-codes-container' ).html( Html );
                        }
                    }
				});
			});
			
			
			this.Container.find( '.js-refresh-codes-button' ).click( function( event ) {
				event.preventDefault();
				
				$.ajax({
					data: {
						'action' : 'refresh_codes'
					},
					success: function( Response ) {
                        if ( typeof Response.data !== 'undefined' ) {
							var Html = '';
							
							for( var i in Response.data ) {
								Html += '<div class="g-mb10">' + Response.data[ i ][ 'id' ] + ' | ' + Response.data[ i ][ 'row_time' ] + ' | ' + Response.data[ i ][ 'row_code' ] + '</div>'
							}
                            $this.Container.find( '.js-codes-container' ).html( Html );
                        }
                    }
				});
			});
			
			
			this.Container.find( '.js-clear-codes-button' ).click( function( event ) {
				event.preventDefault();
				
				$.ajax({
					data: {
						'action' : 'clear_codes'
					},
					success: function( Response ) {
                        if ( typeof Response.status !== 'undefined' && Response.status == 'ok' ) {
                            $this.Container.find( '.js-codes-container' ).html( '' );
                        }
                    }
				});
			});
			
			
			return false;
		}
	};
	
	
	$( document ).ready( function() {
		
		new Actions( '.js-replication-page' );
		
	});
	
})(jQuery)
