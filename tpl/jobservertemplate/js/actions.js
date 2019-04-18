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
		Timers: {},
		HeartbeatDelay: 3000,
		init: function() {
			$.ajaxSetup({
				type: 'POST',
				url: '/jobserver_ajax/',
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
							var RowObject = $( '<div/>' ).addClass( 'g-mb10 js-row' ).attr( 'data-row-id', Response.data.id ).attr( 'data-row-processed', Response.data.row_code_processed ? 1 : 0 );
							RowObject.append( Response.data.id + ' | ' + Response.data.row_time + ' | ' + Response.data.row_code + ' | ' );
							
							var ProcessedObject = $( '<span/>' ).addClass( 'js-processed' );
							if ( Response.data.row_code_processed ) {
								ProcessedObject.html( Response.data.row_code_processed );
							} else {
								ProcessedObject.html( 'processing...' );
							}
							RowObject.append( ProcessedObject );
							
                            $this.Container.find( '.js-codes-container' ).append( RowObject );
                            
                            $this.startCheckingJobAccomplishment();
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
							var RowObject;
							var ProcessedObject;
							
							$this.Container.find( '.js-codes-container' ).html( '' );
							
							for( var i in Response.data ) {
								RowObject = $( '<div/>' ).addClass( 'g-mb10 js-row' ).attr( 'data-row-id', Response.data[ i ].id ).attr( 'data-row-processed', Response.data[ i ].row_code_processed ? 1 : 0 );
								RowObject.append( Response.data[ i ].id + ' | ' + Response.data[ i ].row_time + ' | ' + Response.data[ i ].row_code + ' | ' );
								
								ProcessedObject = $( '<span/>' ).addClass( 'js-processed' );
								if ( Response.data[ i ].row_code_processed ) {
									ProcessedObject.html( Response.data[ i ].row_code_processed );
								} else {
									ProcessedObject.html( 'processing...' );
								}
								RowObject.append( ProcessedObject );
								
								$this.Container.find( '.js-codes-container' ).append( RowObject );
							}
							
							$this.startCheckingJobAccomplishment();
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
                        
                        $this.clearHartbreakTimeouts();
                    }
				});
			});
			
			
			this.startCheckingJobAccomplishment();
			
			
			return false;
		},
		startCheckingJobAccomplishment: function() {
			var $this = this;

			this.clearHartbreakTimeouts();

			this.Container.find( '.js-row[data-row-processed="0"]' ).each( function() {
				var RowId = $( this ).attr( 'data-row-id' );

				if ( typeof $this.Timers[ RowId ] !== 'undefined' ) {
					clearTimeoutin( $this.Timers[ RowId ] );
				}

				$this.Timers[ RowId ] = setTimeout(
					function() {
						$this.checkJobAccomplishment( RowId );
					},
					$this.HeartbeatDelay
				);
			});
			
			return false;
		},
		checkJobAccomplishment: function( RowId ) {
			var $this = this;

			clearTimeout( $this.Timers[ RowId ] );

			$.ajax({
				data: {
					action: 'check_job_accomplishment',
					row_id: RowId
				},
				success: function( Response ) {
					if ( Response.status === 'ok' && typeof Response.data !== 'undefined' ) {
						$this.Container.find( '.js-row[data-row-id="' + Response.data.row_id + '"] .js-processed' ).html( Response.data.row_code_processed );
					} else {
						$this.Timers[ RowId ] = setTimeout(
							function() {
								$this.checkJobAccomplishment( RowId );
							},
							$this.HeartbeatDelay
						);
					}
				}
			});
		},
		clearHartbreakTimeouts: function() {
			for ( var i in this.Timers ) {
				clearTimeout( this.Timers[ i ] );
			}
			
			this.Timers = {};
			
			return false;
		}
	};
	
	
	$( document ).ready( function() {
		
		new Actions( '.js-jobserver-page' );
		
	});
	
})(jQuery)
