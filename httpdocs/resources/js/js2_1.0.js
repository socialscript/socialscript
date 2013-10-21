	/*!
	 * jQuery UI @VERSION
	 *
	 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
	 * Dual licensed under the MIT or GPL Version 2 licenses.
	 * http://jquery.org/license
	 *
	 * http://docs.jquery.com/UI
	 */
	(function( $, undefined ) {

	// prevent duplicate loading
	// this is only a problem because we proxy existing functions
	// and we don't want to double proxy them
	$.ui = $.ui || {};
	if ( $.ui.version ) {
		return;
	}

	$.extend( $.ui, {
		version: "@VERSION",

		keyCode: {
			ALT: 18,
			BACKSPACE: 8,
			CAPS_LOCK: 20,
			COMMA: 188,
			COMMAND: 91,
			COMMAND_LEFT: 91, // COMMAND
			COMMAND_RIGHT: 93,
			CONTROL: 17,
			DELETE: 46,
			DOWN: 40,
			END: 35,
			ENTER: 13,
			ESCAPE: 27,
			HOME: 36,
			INSERT: 45,
			LEFT: 37,
			MENU: 93, // COMMAND_RIGHT
			NUMPAD_ADD: 107,
			NUMPAD_DECIMAL: 110,
			NUMPAD_DIVIDE: 111,
			NUMPAD_ENTER: 108,
			NUMPAD_MULTIPLY: 106,
			NUMPAD_SUBTRACT: 109,
			PAGE_DOWN: 34,
			PAGE_UP: 33,
			PERIOD: 190,
			RIGHT: 39,
			SHIFT: 16,
			SPACE: 32,
			TAB: 9,
			UP: 38,
			WINDOWS: 91 // COMMAND
		}
	});

	// plugins
	$.fn.extend({
		propAttr: $.fn.prop || $.fn.attr,

		_focus: $.fn.focus,
		focus: function( delay, fn ) {
			return typeof delay === "number" ?
				this.each(function() {
					var elem = this;
					setTimeout(function() {
						$( elem ).focus();
						if ( fn ) {
							fn.call( elem );
						}
					}, delay );
				}) :
				this._focus.apply( this, arguments );
		},

		scrollParent: function() {
			var scrollParent;
			if (($.browser.msie && (/(static|relative)/).test(this.css('position'))) || (/absolute/).test(this.css('position'))) {
				scrollParent = this.parents().filter(function() {
					return (/(relative|absolute|fixed)/).test($.curCSS(this,'position',1)) && (/(auto|scroll)/).test($.curCSS(this,'overflow',1)+$.curCSS(this,'overflow-y',1)+$.curCSS(this,'overflow-x',1));
				}).eq(0);
			} else {
				scrollParent = this.parents().filter(function() {
					return (/(auto|scroll)/).test($.curCSS(this,'overflow',1)+$.curCSS(this,'overflow-y',1)+$.curCSS(this,'overflow-x',1));
				}).eq(0);
			}

			return (/fixed/).test(this.css('position')) || !scrollParent.length ? $(document) : scrollParent;
		},

		zIndex: function( zIndex ) {
			if ( zIndex !== undefined ) {
				return this.css( "zIndex", zIndex );
			}

			if ( this.length ) {
				var elem = $( this[ 0 ] ), position, value;
				while ( elem.length && elem[ 0 ] !== document ) {
					// Ignore z-index if position is set to a value where z-index is ignored by the browser
					// This makes behavior of this function consistent across browsers
					// WebKit always returns auto if the element is positioned
					position = elem.css( "position" );
					if ( position === "absolute" || position === "relative" || position === "fixed" ) {
						// IE returns 0 when zIndex is not specified
						// other browsers return a string
						// we ignore the case of nested elements with an explicit value of 0
						// <div style="z-index: -10;"><div style="z-index: 0;"></div></div>
						value = parseInt( elem.css( "zIndex" ), 10 );
						if ( !isNaN( value ) && value !== 0 ) {
							return value;
						}
					}
					elem = elem.parent();
				}
			}

			return 0;
		},

		disableSelection: function() {
			return this.bind( ( $.support.selectstart ? "selectstart" : "mousedown" ) +
				".ui-disableSelection", function( event ) {
					event.preventDefault();
				});
		},

		enableSelection: function() {
			return this.unbind( ".ui-disableSelection" );
		}
	});

	$.each( [ "Width", "Height" ], function( i, name ) {
		var side = name === "Width" ? [ "Left", "Right" ] : [ "Top", "Bottom" ],
			type = name.toLowerCase(),
			orig = {
				innerWidth: $.fn.innerWidth,
				innerHeight: $.fn.innerHeight,
				outerWidth: $.fn.outerWidth,
				outerHeight: $.fn.outerHeight
			};

		function reduce( elem, size, border, margin ) {
			$.each( side, function() {
				size -= parseFloat( $.curCSS( elem, "padding" + this, true) ) || 0;
				if ( border ) {
					size -= parseFloat( $.curCSS( elem, "border" + this + "Width", true) ) || 0;
				}
				if ( margin ) {
					size -= parseFloat( $.curCSS( elem, "margin" + this, true) ) || 0;
				}
			});
			return size;
		}

		$.fn[ "inner" + name ] = function( size ) {
			if ( size === undefined ) {
				return orig[ "inner" + name ].call( this );
			}

			return this.each(function() {
				$( this ).css( type, reduce( this, size ) + "px" );
			});
		};

		$.fn[ "outer" + name] = function( size, margin ) {
			if ( typeof size !== "number" ) {
				return orig[ "outer" + name ].call( this, size );
			}

			return this.each(function() {
				$( this).css( type, reduce( this, size, true, margin ) + "px" );
			});
		};
	});

	// selectors
	function focusable( element, isTabIndexNotNaN ) {
		var nodeName = element.nodeName.toLowerCase();
		if ( "area" === nodeName ) {
			var map = element.parentNode,
				mapName = map.name,
				img;
			if ( !element.href || !mapName || map.nodeName.toLowerCase() !== "map" ) {
				return false;
			}
			img = $( "img[usemap=#" + mapName + "]" )[0];
			return !!img && visible( img );
		}
		return ( /input|select|textarea|button|object/.test( nodeName )
			? !element.disabled
			: "a" == nodeName
				? element.href || isTabIndexNotNaN
				: isTabIndexNotNaN)
			// the element and all of its ancestors must be visible
			&& visible( element );
	}

	function visible( element ) {
		return !$( element ).parents().andSelf().filter(function() {
			return $.curCSS( this, "visibility" ) === "hidden" ||
				$.expr.filters.hidden( this );
		}).length;
	}

	$.extend( $.expr[ ":" ], {
		data: function( elem, i, match ) {
			return !!$.data( elem, match[ 3 ] );
		},

		focusable: function( element ) {
			return focusable( element, !isNaN( $.attr( element, "tabindex" ) ) );
		},

		tabbable: function( element ) {
			var tabIndex = $.attr( element, "tabindex" ),
				isTabIndexNaN = isNaN( tabIndex );
			return ( isTabIndexNaN || tabIndex >= 0 ) && focusable( element, !isTabIndexNaN );
		}
	});

	// support
	$(function() {
		var body = document.body,
			div = body.appendChild( div = document.createElement( "div" ) );

		// access offsetHeight before setting the style to prevent a layout bug
		// in IE 9 which causes the elemnt to continue to take up space even
		// after it is removed from the DOM (#8026)
		div.offsetHeight;

		$.extend( div.style, {
			minHeight: "100px",
			height: "auto",
			padding: 0,
			borderWidth: 0
		});

		$.support.minHeight = div.offsetHeight === 100;
		$.support.selectstart = "onselectstart" in div;

		// set display to none to avoid a layout bug in IE
		// http://dev.jquery.com/ticket/4014
		body.removeChild( div ).style.display = "none";
	});





	// deprecated
	$.extend( $.ui, {
		// $.ui.plugin is deprecated.  Use the proxy pattern instead.
		plugin: {
			add: function( module, option, set ) {
				var proto = $.ui[ module ].prototype;
				for ( var i in set ) {
					proto.plugins[ i ] = proto.plugins[ i ] || [];
					proto.plugins[ i ].push( [ option, set[ i ] ] );
				}
			},
			call: function( instance, name, args ) {
				var set = instance.plugins[ name ];
				if ( !set || !instance.element[ 0 ].parentNode ) {
					return;
				}

				for ( var i = 0; i < set.length; i++ ) {
					if ( instance.options[ set[ i ][ 0 ] ] ) {
						set[ i ][ 1 ].apply( instance.element, args );
					}
				}
			}
		},

		// will be deprecated when we switch to jQuery 1.4 - use jQuery.contains()
		contains: function( a, b ) {
			return document.compareDocumentPosition ?
				a.compareDocumentPosition( b ) & 16 :
				a !== b && a.contains( b );
		},

		// only used by resizable
		hasScroll: function( el, a ) {

			//If overflow is hidden, the element might have extra content, but the user wants to hide it
			if ( $( el ).css( "overflow" ) === "hidden") {
				return false;
			}

			var scroll = ( a && a === "left" ) ? "scrollLeft" : "scrollTop",
				has = false;

			if ( el[ scroll ] > 0 ) {
				return true;
			}

			// TODO: determine which cases actually cause this to happen
			// if the element doesn't have the scroll set, see if it's possible to
			// set the scroll
			el[ scroll ] = 1;
			has = ( el[ scroll ] > 0 );
			el[ scroll ] = 0;
			return has;
		},

		// these are odd functions, fix the API or move into individual plugins
		isOverAxis: function( x, reference, size ) {
			//Determines when x coordinate is over "b" element axis
			return ( x > reference ) && ( x < ( reference + size ) );
		},
		isOver: function( y, x, top, left, height, width ) {
			//Determines when x, y coordinates is over "b" element
			return $.ui.isOverAxis( y, top, height ) && $.ui.isOverAxis( x, left, width );
		}
	});

	})( jQuery );

	/*!
	 * jQuery UI Widget @VERSION
	 *
	 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
	 * Dual licensed under the MIT or GPL Version 2 licenses.
	 * http://jquery.org/license
	 *
	 * http://docs.jquery.com/UI/Widget
	 */
	(function( $, undefined ) {

	// jQuery 1.4+
	if ( $.cleanData ) {
		var _cleanData = $.cleanData;
		$.cleanData = function( elems ) {
			for ( var i = 0, elem; (elem = elems[i]) != null; i++ ) {
				try {
					$( elem ).triggerHandler( "remove" );
				// http://bugs.jquery.com/ticket/8235
				} catch( e ) {}
			}
			_cleanData( elems );
		};
	} else {
		var _remove = $.fn.remove;
		$.fn.remove = function( selector, keepData ) {
			return this.each(function() {
				if ( !keepData ) {
					if ( !selector || $.filter( selector, [ this ] ).length ) {
						$( "*", this ).add( [ this ] ).each(function() {
							try {
								$( this ).triggerHandler( "remove" );
							// http://bugs.jquery.com/ticket/8235
							} catch( e ) {}
						});
					}
				}
				return _remove.call( $(this), selector, keepData );
			});
		};
	}

	$.widget = function( name, base, prototype ) {
		var namespace = name.split( "." )[ 0 ],
			fullName;
		name = name.split( "." )[ 1 ];
		fullName = namespace + "-" + name;

		if ( !prototype ) {
			prototype = base;
			base = $.Widget;
		}

		// create selector for plugin
		$.expr[ ":" ][ fullName ] = function( elem ) {
			return !!$.data( elem, name );
		};

		$[ namespace ] = $[ namespace ] || {};
		$[ namespace ][ name ] = function( options, element ) {
			// allow instantiation without initializing for simple inheritance
			if ( arguments.length ) {
				this._createWidget( options, element );
			}
		};

		var basePrototype = new base();
		// we need to make the options hash a property directly on the new instance
		// otherwise we'll modify the options hash on the prototype that we're
		// inheriting from
	//	$.each( basePrototype, function( key, val ) {
	//		if ( $.isPlainObject(val) ) {
	//			basePrototype[ key ] = $.extend( {}, val );
	//		}
	//	});
		basePrototype.options = $.extend( true, {}, basePrototype.options );
		$[ namespace ][ name ].prototype = $.extend( true, basePrototype, {
			namespace: namespace,
			widgetName: name,
			widgetEventPrefix: $[ namespace ][ name ].prototype.widgetEventPrefix || name,
			widgetBaseClass: fullName
		}, prototype );

		$.widget.bridge( name, $[ namespace ][ name ] );
	};

	$.widget.bridge = function( name, object ) {
		$.fn[ name ] = function( options ) {
			var isMethodCall = typeof options === "string",
				args = Array.prototype.slice.call( arguments, 1 ),
				returnValue = this;

			// allow multiple hashes to be passed on init
			options = !isMethodCall && args.length ?
				$.extend.apply( null, [ true, options ].concat(args) ) :
				options;

			// prevent calls to internal methods
			if ( isMethodCall && options.charAt( 0 ) === "_" ) {
				return returnValue;
			}

			if ( isMethodCall ) {
				this.each(function() {
					var instance = $.data( this, name ),
						methodValue = instance && $.isFunction( instance[options] ) ?
							instance[ options ].apply( instance, args ) :
							instance;
					// TODO: add this back in 1.9 and use $.error() (see #5972)
	//				if ( !instance ) {
	//					throw "cannot call methods on " + name + " prior to initialization; " +
	//						"attempted to call method '" + options + "'";
	//				}
	//				if ( !$.isFunction( instance[options] ) ) {
	//					throw "no such method '" + options + "' for " + name + " widget instance";
	//				}
	//				var methodValue = instance[ options ].apply( instance, args );
					if ( methodValue !== instance && methodValue !== undefined ) {
						returnValue = methodValue;
						return false;
					}
				});
			} else {
				this.each(function() {
					var instance = $.data( this, name );
					if ( instance ) {
						instance.option( options || {} )._init();
					} else {
						$.data( this, name, new object( options, this ) );
					}
				});
			}

			return returnValue;
		};
	};

	$.Widget = function( options, element ) {
		// allow instantiation without initializing for simple inheritance
		if ( arguments.length ) {
			this._createWidget( options, element );
		}
	};

	$.Widget.prototype = {
		widgetName: "widget",
		widgetEventPrefix: "",
		options: {
			disabled: false
		},
		_createWidget: function( options, element ) {
			// $.widget.bridge stores the plugin instance, but we do it anyway
			// so that it's stored even before the _create function runs
			$.data( element, this.widgetName, this );
			this.element = $( element );
			this.options = $.extend( true, {},
				this.options,
				this._getCreateOptions(),
				options );

			var self = this;
			this.element.bind( "remove." + this.widgetName, function() {
				self.destroy();
			});

			this._create();
			this._trigger( "create" );
			this._init();
		},
		_getCreateOptions: function() {
			return $.metadata && $.metadata.get( this.element[0] )[ this.widgetName ];
		},
		_create: function() {},
		_init: function() {},

		destroy: function() {
			this.element
				.unbind( "." + this.widgetName )
				.removeData( this.widgetName );
			this.widget()
				.unbind( "." + this.widgetName )
				.removeAttr( "aria-disabled" )
				.removeClass(
					this.widgetBaseClass + "-disabled " +
					"ui-state-disabled" );
		},

		widget: function() {
			return this.element;
		},

		option: function( key, value ) {
			var options = key;

			if ( arguments.length === 0 ) {
				// don't return a reference to the internal hash
				return $.extend( {}, this.options );
			}

			if  (typeof key === "string" ) {
				if ( value === undefined ) {
					return this.options[ key ];
				}
				options = {};
				options[ key ] = value;
			}

			this._setOptions( options );

			return this;
		},
		_setOptions: function( options ) {
			var self = this;
			$.each( options, function( key, value ) {
				self._setOption( key, value );
			});

			return this;
		},
		_setOption: function( key, value ) {
			this.options[ key ] = value;

			if ( key === "disabled" ) {
				this.widget()
					[ value ? "addClass" : "removeClass"](
						this.widgetBaseClass + "-disabled" + " " +
						"ui-state-disabled" )
					.attr( "aria-disabled", value );
			}

			return this;
		},

		enable: function() {
			return this._setOption( "disabled", false );
		},
		disable: function() {
			return this._setOption( "disabled", true );
		},

		_trigger: function( type, event, data ) {
			var prop, orig,
				callback = this.options[ type ];

			data = data || {};
			event = $.Event( event );
			event.type = ( type === this.widgetEventPrefix ?
				type :
				this.widgetEventPrefix + type ).toLowerCase();
			// the original event may come from any element
			// so we need to reset the target on the new event
			event.target = this.element[ 0 ];

			// copy original event properties over to the new event
			orig = event.originalEvent;
			if ( orig ) {
				for ( prop in orig ) {
					if ( !( prop in event ) ) {
						event[ prop ] = orig[ prop ];
					}
				}
			}

			this.element.trigger( event, data );

			return !( $.isFunction(callback) &&
				callback.call( this.element[0], event, data ) === false ||
				event.isDefaultPrevented() );
		}
	};

	})( jQuery );

	/*!
	 * jQuery UI Position @VERSION
	 *
	 * Copyright 2012, AUTHORS.txt (http://jqueryui.com/about)
	 * Dual licensed under the MIT or GPL Version 2 licenses.
	 * http://jquery.org/license
	 *
	 * http://docs.jquery.com/UI/Position
	 */
	(function( $, undefined ) {

	$.ui = $.ui || {};

	var horizontalPositions = /left|center|right/,
		verticalPositions = /top|center|bottom/,
		center = "center",
		support = {},
		_position = $.fn.position,
		_offset = $.fn.offset;

	$.fn.position = function( options ) {
		if ( !options || !options.of ) {
			return _position.apply( this, arguments );
		}

		// make a copy, we don't want to modify arguments
		options = $.extend( {}, options );

		var target = $( options.of ),
			targetElem = target[0],
			collision = ( options.collision || "flip" ).split( " " ),
			offset = options.offset ? options.offset.split( " " ) : [ 0, 0 ],
			targetWidth,
			targetHeight,
			basePosition;

		if ( targetElem.nodeType === 9 ) {
			targetWidth = target.width();
			targetHeight = target.height();
			basePosition = { top: 0, left: 0 };
		// TODO: use $.isWindow() in 1.9
		} else if ( targetElem.setTimeout ) {
			targetWidth = target.width();
			targetHeight = target.height();
			basePosition = { top: target.scrollTop(), left: target.scrollLeft() };
		} else if ( targetElem.preventDefault ) {
			// force left top to allow flipping
			options.at = "left top";
			targetWidth = targetHeight = 0;
			basePosition = { top: options.of.pageY, left: options.of.pageX };
		} else {
			targetWidth = target.outerWidth();
			targetHeight = target.outerHeight();
			basePosition = target.offset();
		}

		// force my and at to have valid horizontal and veritcal positions
		// if a value is missing or invalid, it will be converted to center
		$.each( [ "my", "at" ], function() {
			var pos = ( options[this] || "" ).split( " " );
			if ( pos.length === 1) {
				pos = horizontalPositions.test( pos[0] ) ?
					pos.concat( [center] ) :
					verticalPositions.test( pos[0] ) ?
						[ center ].concat( pos ) :
						[ center, center ];
			}
			pos[ 0 ] = horizontalPositions.test( pos[0] ) ? pos[ 0 ] : center;
			pos[ 1 ] = verticalPositions.test( pos[1] ) ? pos[ 1 ] : center;
			options[ this ] = pos;
		});

		// normalize collision option
		if ( collision.length === 1 ) {
			collision[ 1 ] = collision[ 0 ];
		}

		// normalize offset option
		offset[ 0 ] = parseInt( offset[0], 10 ) || 0;
		if ( offset.length === 1 ) {
			offset[ 1 ] = offset[ 0 ];
		}
		offset[ 1 ] = parseInt( offset[1], 10 ) || 0;

		if ( options.at[0] === "right" ) {
			basePosition.left += targetWidth;
		} else if ( options.at[0] === center ) {
			basePosition.left += targetWidth / 2;
		}

		if ( options.at[1] === "bottom" ) {
			basePosition.top += targetHeight;
		} else if ( options.at[1] === center ) {
			basePosition.top += targetHeight / 2;
		}

		basePosition.left += offset[ 0 ];
		basePosition.top += offset[ 1 ];

		return this.each(function() {
			var elem = $( this ),
				elemWidth = elem.outerWidth(),
				elemHeight = elem.outerHeight(),
				marginLeft = parseInt( $.curCSS( this, "marginLeft", true ) ) || 0,
				marginTop = parseInt( $.curCSS( this, "marginTop", true ) ) || 0,
				collisionWidth = elemWidth + marginLeft +
					( parseInt( $.curCSS( this, "marginRight", true ) ) || 0 ),
				collisionHeight = elemHeight + marginTop +
					( parseInt( $.curCSS( this, "marginBottom", true ) ) || 0 ),
				position = $.extend( {}, basePosition ),
				collisionPosition;

			if ( options.my[0] === "right" ) {
				position.left -= elemWidth;
			} else if ( options.my[0] === center ) {
				position.left -= elemWidth / 2;
			}

			if ( options.my[1] === "bottom" ) {
				position.top -= elemHeight;
			} else if ( options.my[1] === center ) {
				position.top -= elemHeight / 2;
			}

			// prevent fractions if jQuery version doesn't support them (see #5280)
			if ( !support.fractions ) {
				position.left = Math.round( position.left );
				position.top = Math.round( position.top );
			}

			collisionPosition = {
				left: position.left - marginLeft,
				top: position.top - marginTop
			};

			$.each( [ "left", "top" ], function( i, dir ) {
				if ( $.ui.position[ collision[i] ] ) {
					$.ui.position[ collision[i] ][ dir ]( position, {
						targetWidth: targetWidth,
						targetHeight: targetHeight,
						elemWidth: elemWidth,
						elemHeight: elemHeight,
						collisionPosition: collisionPosition,
						collisionWidth: collisionWidth,
						collisionHeight: collisionHeight,
						offset: offset,
						my: options.my,
						at: options.at
					});
				}
			});

			if ( $.fn.bgiframe ) {
				elem.bgiframe();
			}
			elem.offset( $.extend( position, { using: options.using } ) );
		});
	};

	$.ui.position = {
		fit: {
			left: function( position, data ) {
				var win = $( window ),
					over = data.collisionPosition.left + data.collisionWidth - win.width() - win.scrollLeft();
				position.left = over > 0 ? position.left - over : Math.max( position.left - data.collisionPosition.left, position.left );
			},
			top: function( position, data ) {
				var win = $( window ),
					over = data.collisionPosition.top + data.collisionHeight - win.height() - win.scrollTop();
				position.top = over > 0 ? position.top - over : Math.max( position.top - data.collisionPosition.top, position.top );
			}
		},

		flip: {
			left: function( position, data ) {
				if ( data.at[0] === center ) {
					return;
				}
				var win = $( window ),
					over = data.collisionPosition.left + data.collisionWidth - win.width() - win.scrollLeft(),
					myOffset = data.my[ 0 ] === "left" ?
						-data.elemWidth :
						data.my[ 0 ] === "right" ?
							data.elemWidth :
							0,
					atOffset = data.at[ 0 ] === "left" ?
						data.targetWidth :
						-data.targetWidth,
					offset = -2 * data.offset[ 0 ];
				position.left += data.collisionPosition.left < 0 ?
					myOffset + atOffset + offset :
					over > 0 ?
						myOffset + atOffset + offset :
						0;
			},
			top: function( position, data ) {
				if ( data.at[1] === center ) {
					return;
				}
				var win = $( window ),
					over = data.collisionPosition.top + data.collisionHeight - win.height() - win.scrollTop(),
					myOffset = data.my[ 1 ] === "top" ?
						-data.elemHeight :
						data.my[ 1 ] === "bottom" ?
							data.elemHeight :
							0,
					atOffset = data.at[ 1 ] === "top" ?
						data.targetHeight :
						-data.targetHeight,
					offset = -2 * data.offset[ 1 ];
				position.top += data.collisionPosition.top < 0 ?
					myOffset + atOffset + offset :
					over > 0 ?
						myOffset + atOffset + offset :
						0;
			}
		}
	};

	// offset setter from jQuery 1.4
	if ( !$.offset.setOffset ) {
		$.offset.setOffset = function( elem, options ) {
			// set position first, in-case top/left are set even on static elem
			if ( /static/.test( $.curCSS( elem, "position" ) ) ) {
				elem.style.position = "relative";
			}
			var curElem   = $( elem ),
				curOffset = curElem.offset(),
				curTop    = parseInt( $.curCSS( elem, "top",  true ), 10 ) || 0,
				curLeft   = parseInt( $.curCSS( elem, "left", true ), 10)  || 0,
				props     = {
					top:  (options.top  - curOffset.top)  + curTop,
					left: (options.left - curOffset.left) + curLeft
				};

			if ( 'using' in options ) {
				options.using.call( elem, props );
			} else {
				curElem.css( props );
			}
		};

		$.fn.offset = function( options ) {
			var elem = this[ 0 ];
			if ( !elem || !elem.ownerDocument ) { return null; }
			if ( options ) {
				return this.each(function() {
					$.offset.setOffset( this, options );
				});
			}
			return _offset.call( this );
		};
	}

	// fraction support test (older versions of jQuery don't support fractions)
	(function () {
		var body = document.getElementsByTagName( "body" )[ 0 ],
			div = document.createElement( "div" ),
			testElement, testElementParent, testElementStyle, offset, offsetTotal;

		//Create a "fake body" for testing based on method used in jQuery.support
		testElement = document.createElement( body ? "div" : "body" );
		testElementStyle = {
			visibility: "hidden",
			width: 0,
			height: 0,
			border: 0,
			margin: 0,
			background: "none"
		};
		if ( body ) {
			$.extend( testElementStyle, {
				position: "absolute",
				left: "-1000px",
				top: "-1000px"
			});
		}
		for ( var i in testElementStyle ) {
			testElement.style[ i ] = testElementStyle[ i ];
		}
		testElement.appendChild( div );
		testElementParent = body || document.documentElement;
		testElementParent.insertBefore( testElement, testElementParent.firstChild );

		div.style.cssText = "position: absolute; left: 10.7432222px; top: 10.432325px; height: 30px; width: 201px;";

		offset = $( div ).offset( function( _, offset ) {
			return offset;
		}).offset();

		testElement.innerHTML = "";
		testElementParent.removeChild( testElement );

		offsetTotal = offset.top + offset.left + ( body ? 2000 : 0 );
		support.fractions = offsetTotal > 21 && offsetTotal < 22;
	})();

	}( jQuery ));

	/*
	 * jQuery UI selectmenu 1.3.0pre version
	 *
	 * Copyright (c) 2009-2010 filament group, http://filamentgroup.com
	 * Copyright (c) 2010-2012 Felix Nagel, http://www.felixnagel.com
	 * Dual licensed under the MIT (MIT-LICENSE.txt)
	 * and GPL (GPL-LICENSE.txt) licenses.
	 *
	 * http://docs.jquery.com/UI
	 * https://github.com/fnagel/jquery-ui/wiki/Selectmenu
	 */

	(function($) {

	$.widget("ui.selectmenu", {
		options: {
			appendTo: "body",
			typeAhead: 1000,
			style: 'dropdown',
			positionOptions: {
				my: "left top",
				at: "left bottom",
				offset: null
			},
			width: null,
			menuWidth: null,
			handleWidth: 26,
			maxHeight: null,
			icons: null,
			format: null,
			escapeHtml: false,
			bgImage: function() {}
		},

		_create: function() {
			var self = this, o = this.options;

			// set a default id value, generate a new random one if not set by developer
			var selectmenuId = (this.element.attr( 'id' ) || 'ui-selectmenu-' + Math.random().toString( 16 ).slice( 2, 10 )).replace(/(:|\.)/g,'')

			// quick array of button and menu id's
			this.ids = [ selectmenuId, selectmenuId + '-button', selectmenuId + '-menu' ];

			// define safe mouseup for future toggling
			this._safemouseup = true;
			this.isOpen = false;

			// create menu button wrapper
			this.newelement = $( '<a />', {
				'class': this.widgetBaseClass + ' ui-widget ui-nocorner-all',
				'id' : this.ids[ 1 ],
				'role': 'button',
				'href': '#nogo',
				'tabindex': this.element.attr( 'disabled' ) ? 1 : 0,
				'aria-haspopup': true,
				'aria-owns': this.ids[ 2 ]
			});
			this.newelementWrap = $( "<span />" )
				.append( this.newelement )
				.insertAfter( this.element );

			// transfer tabindex
			var tabindex = this.element.attr( 'tabindex' );
			if ( tabindex ) {
				this.newelement.attr( 'tabindex', tabindex );
			}

			// save reference to select in data for ease in calling methods
			this.newelement.data( 'selectelement', this.element );

			// menu icon
			this.selectmenuIcon = $( '<span class="' + this.widgetBaseClass + '-icon ui-icon"></span>' )
				.prependTo( this.newelement );

			// append status span to button
			this.newelement.prepend( '<span class="' + self.widgetBaseClass + '-status" />' );

			// make associated form label trigger focus
			this.element.bind({
				'click.selectmenu':  function( event ) {
					self.newelement.focus();
					event.preventDefault();
				}
			});

			// click toggle for menu visibility
			this.newelement
				.bind('mousedown.selectmenu', function(event) {
					self._toggle(event, true);
					// make sure a click won't open/close instantly
					if (o.style == "popup") {
						self._safemouseup = false;
						setTimeout(function() { self._safemouseup = true; }, 300);
					}
					return false;
				})
				.bind('click.selectmenu', function() {
					return false;
				})
				.bind("keydown.selectmenu", function(event) {
					var ret = false;
					switch (event.keyCode) {
						case $.ui.keyCode.ENTER:
							ret = true;
							break;
						case $.ui.keyCode.SPACE:
							self._toggle(event);
							break;
						case $.ui.keyCode.UP:
							if (event.altKey) {
								self.open(event);
							} else {
								self._moveSelection(-1);
							}
							break;
						case $.ui.keyCode.DOWN:
							if (event.altKey) {
								self.open(event);
							} else {
								self._moveSelection(1);
							}
							break;
						case $.ui.keyCode.LEFT:
							self._moveSelection(-1);
							break;
						case $.ui.keyCode.RIGHT:
							self._moveSelection(1);
							break;
						case $.ui.keyCode.TAB:
							ret = true;
							break;
						case $.ui.keyCode.PAGE_UP:
						case $.ui.keyCode.HOME:
							self.index(0);
							break;
						case $.ui.keyCode.PAGE_DOWN:
						case $.ui.keyCode.END:
							self.index(self._optionLis.length);
							break;
						default:
							ret = true;
					}
					return ret;
				})
				.bind('keypress.selectmenu', function(event) {
					if (event.which > 0) {
						self._typeAhead(event.which, 'mouseup');
					}
					return true;
				})
				.bind('mouseover.selectmenu', function() {
					if (!o.disabled) $(this).addClass('ui-state-nohover');
				})
				.bind('mouseout.selectmenu', function() {
					if (!o.disabled) $(this).removeClass('ui-state-nohover');
				})
				.bind('focus.selectmenu', function() {
					if (!o.disabled) $(this).addClass('ui-state-nofocus');
				})
				.bind('blur.selectmenu', function() {
					if (!o.disabled) $(this).removeClass('ui-state-nofocus');
				});

			// document click closes menu
			$(document).bind("mousedown.selectmenu-" + this.ids[0], function(event) {
				if ( self.isOpen ) {
					self.close( event );
				}
			});

			// change event on original selectmenu
			this.element
				.bind("click.selectmenu", function() {
					self._refreshValue();
				})
				// FIXME: newelement can be null under unclear circumstances in IE8
				// TODO not sure if this is still a problem (fnagel 20.03.11)
				.bind("focus.selectmenu", function() {
					if (self.newelement) {
						self.newelement[0].focus();
					}
				});

			// set width when not set via options
			if (!o.width) {
				o.width = this.element.outerWidth();
			}
			// set menu button width
			this.newelement.width(o.width);

			// hide original selectmenu element
			this.element.hide();

			// create menu portion, append to body
			this.list = $( '<ul />', {
				'class': 'ui-widget ui-widget-content',
				'aria-hidden': true,
				'role': 'listbox',
				'aria-labelledby': this.ids[1],
				'id': this.ids[2]
			});
			this.listWrap = $( "<div />", {
				'class': self.widgetBaseClass + '-menu'
			}).append( this.list ).appendTo( o.appendTo );

			// transfer menu click to menu button
			this.list
				.bind("keydown.selectmenu", function(event) {
					var ret = false;
					switch (event.keyCode) {
						case $.ui.keyCode.UP:
							if (event.altKey) {
								self.close(event, true);
							} else {
								self._moveFocus(-1);
							}
							break;
						case $.ui.keyCode.DOWN:
							if (event.altKey) {
								self.close(event, true);
							} else {
								self._moveFocus(1);
							}
							break;
						case $.ui.keyCode.LEFT:
							self._moveFocus(-1);
							break;
						case $.ui.keyCode.RIGHT:
							self._moveFocus(1);
							break;
						case $.ui.keyCode.HOME:
							self._moveFocus(':first');
							break;
						case $.ui.keyCode.PAGE_UP:
							self._scrollPage('up');
							break;
						case $.ui.keyCode.PAGE_DOWN:
							self._scrollPage('down');
							break;
						case $.ui.keyCode.END:
							self._moveFocus(':last');
							break;
						case $.ui.keyCode.ENTER:
						case $.ui.keyCode.SPACE:
							self.close(event, true);
							$(event.target).parents('li:eq(0)').trigger('mouseup');
							break;
						case $.ui.keyCode.TAB:
							ret = true;
							self.close(event, true);
							$(event.target).parents('li:eq(0)').trigger('mouseup');
							break;
						case $.ui.keyCode.ESCAPE:
							self.close(event, true);
							break;
						default:
							ret = true;
					}
					return ret;
				})
				.bind('keypress.selectmenu', function(event) {
					if (event.which > 0) {
						self._typeAhead(event.which, 'focus');
					}
					return true;
				})
				// this allows for using the scrollbar in an overflowed list
				.bind( 'mousedown.selectmenu mouseup.selectmenu', function() { return false; });

			// needed when window is resized
			$(window).bind( "resize.selectmenu-" + this.ids[0], $.proxy( self.close, this ) );
		},

		_init: function() {
			var self = this, o = this.options;

			// serialize selectmenu element options
			var selectOptionData = [];
			this.element.find('option').each(function() {
				var opt = $(this);
				selectOptionData.push({
					value: opt.attr('value'),
					text: self._formatText(opt.text()),
					selected: opt.attr('selected'),
					disabled: opt.attr('disabled'),
					classes: opt.attr('class'),
					typeahead: opt.attr('typeahead'),
					parentOptGroup: opt.parent('optgroup'),
					bgImage: o.bgImage.call(opt)
				});
			});

			// active state class is only used in popup style
			var activeClass = (self.options.style == "popup") ? " ui-state-active" : "";

			// empty list so we can refresh the selectmenu via selectmenu()
			this.list.html("");

			// write li's
			if (selectOptionData.length) {
				for (var i = 0; i < selectOptionData.length; i++) {
					var thisLiAttr = { role : 'presentation' };
					if ( selectOptionData[ i ].disabled ) {
						thisLiAttr[ 'class' ] = this.namespace + '-state-disabled';
					}
					var thisAAttr = {
						html: selectOptionData[i].text || '&nbsp;',
						href : '#nogo',
						tabindex : -1,
						role : 'option',
						'aria-selected' : false,
						focus: function() {
						    // bubble the focus event
							// TODO: this isnt a clean solution, see #241
						    $(this).parent().focus();
						}
					};
					if ( selectOptionData[ i ].disabled ) {
						thisAAttr[ 'aria-disabled' ] = selectOptionData[ i ].disabled;
					}
					if ( selectOptionData[ i ].typeahead ) {
						thisAAttr[ 'typeahead' ] = selectOptionData[ i ].typeahead;
					}
					var thisA = $('<a/>', thisAAttr);
					var thisLi = $('<li/>', thisLiAttr)
						.append(thisA)
						.data('index', i)
						.addClass(selectOptionData[i].classes)
						.data('optionClasses', selectOptionData[i].classes || '')
						.bind("mouseup.selectmenu", function(event) {
							if (self._safemouseup && !self._disabled(event.currentTarget) && !self._disabled($( event.currentTarget ).parents( "ul>li." + self.widgetBaseClass + "-group " )) ) {
								var changed = $(this).data('index') != self._selectedIndex();
								self.index($(this).data('index'));
								self.select(event);
								if (changed) {
									self.change(event);
								}
								self.close(event, true);
							}
							return false;
						})
						.bind("click.selectmenu", function() {
							return false;
						})
						.bind('mouseover.selectmenu focus.selectmenu', function(e) {
							// no hover if diabled
							if (!$(e.currentTarget).hasClass(self.namespace + '-state-disabled') && !$(e.currentTarget).parent("ul").parent("li").hasClass(self.namespace + '-state-disabled')) {
								self._selectedOptionLi().addClass(activeClass);
								self._focusedOptionLi().removeClass(self.widgetBaseClass + '-item-focus ui-state-nohover');
								$(this).removeClass('ui-state-active').addClass(self.widgetBaseClass + '-item-focus ui-state-nohover');
							}
						})
						.bind('mouseout.selectmenu blur.selectmenu', function() {
							if ($(this).is(self._selectedOptionLi().selector)) {
								$(this).addClass(activeClass);
							}
							$(this).removeClass(self.widgetBaseClass + '-item-focus ui-state-nohover');
						});

					// optgroup or not...
					if ( selectOptionData[i].parentOptGroup.length ) {
						var optGroupName = self.widgetBaseClass + '-group-' + this.element.find( 'optgroup' ).index( selectOptionData[i].parentOptGroup );
						if (this.list.find( 'li.' + optGroupName ).length ) {
							this.list.find( 'li.' + optGroupName + ':last ul' ).append( thisLi );
						} else {
							$(' <li role="presentation" class="' + self.widgetBaseClass + '-group ' + optGroupName + (selectOptionData[i].parentOptGroup.attr("disabled") ? ' ' + this.namespace + '-state-disabled" aria-disabled="true"' : '"' ) + '><span class="' + self.widgetBaseClass + '-group-label">' + selectOptionData[i].parentOptGroup.attr('label') + '</span><ul></ul></li> ')
								.appendTo( this.list )
								.find( 'ul' )
								.append( thisLi );
						}
					} else {
						thisLi.appendTo(this.list);
					}

					// append icon if option is specified
					if (o.icons) {
						for (var j in o.icons) {
							if (thisLi.is(o.icons[j].find)) {
								thisLi
									.data('optionClasses', selectOptionData[i].classes + ' ' + self.widgetBaseClass + '-hasIcon')
									.addClass(self.widgetBaseClass + '-hasIcon');
								var iconClass = o.icons[j].icon || "";
								thisLi
									.find('a:eq(0)')
									.prepend('<span class="' + self.widgetBaseClass + '-item-icon ui-icon ' + iconClass + '"></span>');
								if (selectOptionData[i].bgImage) {
									thisLi.find('span').css('background-image', selectOptionData[i].bgImage);
								}
							}
						}
					}
				}
			} else {
				$('<li role="presentation"><a href="#nogo" tabindex="-1" role="option"></a></li>').appendTo(this.list);
			}
			// we need to set and unset the CSS classes for dropdown and popup style
			var isDropDown = ( o.style == 'dropdown' );
			this.newelement
				.toggleClass( self.widgetBaseClass + '-dropdown', isDropDown )
				.toggleClass( self.widgetBaseClass + '-popup', !isDropDown );
			this.list
				.toggleClass( self.widgetBaseClass + '-menu-dropdown ui-nocorner-bottom', isDropDown )
				.toggleClass( self.widgetBaseClass + '-menu-popup ui-nocorner-all', !isDropDown )
				// add corners to top and bottom menu items
				.find( 'li:first' )
				.toggleClass( 'ui-nocorner-top', !isDropDown )
				.end().find( 'li:last' )
				.addClass( 'ui-nocorner-bottom' );
			this.selectmenuIcon
				.toggleClass( 'ui-icon-triangle-1-s', isDropDown )
				.toggleClass( 'ui-icon-triangle-2-n-s', !isDropDown );

			// set menu width to either menuWidth option value, width option value, or select width
			if ( o.style == 'dropdown' ) {
				this.list.width( o.menuWidth ? o.menuWidth : o.width );
			} else {
				this.list.width( o.menuWidth ? o.menuWidth : o.width - o.handleWidth );
			}

			// reset height to auto
			this.list.css( 'height', 'auto' );
			var listH = this.listWrap.height();
			var winH = $( window ).height();
			// calculate default max height
			var maxH = o.maxHeight ? Math.min( o.maxHeight, winH ) : winH / 3;
			if ( listH > maxH ) this.list.height( maxH );

			// save reference to actionable li's (not group label li's)
			this._optionLis = this.list.find( 'li:not(.' + self.widgetBaseClass + '-group)' );

			// transfer disabled state
			if ( this.element.attr( 'disabled' ) ) {
				this.disable();
			} else {
				this.enable();
			}

			// update value
			this._refreshValue();

			// set selected item so movefocus has intial state
			this._selectedOptionLi().addClass(this.widgetBaseClass + '-item-focus');

			// needed when selectmenu is placed at the very bottom / top of the page
			clearTimeout(this.refreshTimeout);
			this.refreshTimeout = window.setTimeout(function () {
				self._refreshPosition();
			}, 200);
		},

		destroy: function() {
			this.element.removeData( this.widgetName )
				.removeClass( this.widgetBaseClass + '-disabled' + ' ' + this.namespace + '-state-disabled' )
				.removeAttr( 'aria-disabled' )
				.unbind( ".selectmenu" );

			$( window ).unbind( ".selectmenu-" + this.ids[0] );
			$( document ).unbind( ".selectmenu-" + this.ids[0] );

			this.newelementWrap.remove();
			this.listWrap.remove();

			// unbind click event and show original select
			this.element
				.unbind(".selectmenu")
				.show();

			// call widget destroy function
			$.Widget.prototype.destroy.apply(this, arguments);
		},

		_typeAhead: function( code, eventType ) {
			var self = this,
				c = String.fromCharCode(code).toLowerCase(),
				matchee = null,
				nextIndex = null;

			// Clear any previous timer if present
			if ( self._typeAhead_timer ) {
				window.clearTimeout( self._typeAhead_timer );
				self._typeAhead_timer = undefined;
			}

			// Store the character typed
			self._typeAhead_chars = (self._typeAhead_chars === undefined ? "" : self._typeAhead_chars).concat(c);

			// Detect if we are in cyciling mode or direct selection mode
			if ( self._typeAhead_chars.length < 2 ||
			     (self._typeAhead_chars.substr(-2, 1) === c && self._typeAhead_cycling) ) {
				self._typeAhead_cycling = true;

				// Match only the first character and loop
				matchee = c;
			}
			else {
				// We won't be cycling anymore until the timer expires
				self._typeAhead_cycling = false;

				// Match all the characters typed
				matchee = self._typeAhead_chars;
			}

			// We need to determine the currently active index, but it depends on
			// the used context: if it's in the element, we want the actual
			// selected index, if it's in the menu, just the focused one
			// I copied this code from _moveSelection() and _moveFocus()
			// respectively --thg2k
			var selectedIndex = (eventType !== 'focus' ?
				this._selectedOptionLi().data('index') :
				this._focusedOptionLi().data('index')) || 0;

			for (var i = 0; i < this._optionLis.length; i++) {
				var thisText = this._optionLis.eq(i).text().substr(0, matchee.length).toLowerCase();

				if ( thisText === matchee ) {
					if ( self._typeAhead_cycling ) {
						if ( nextIndex === null )
							nextIndex = i;

						if ( i > selectedIndex ) {
							nextIndex = i;
							break;
						}
					} else {
						nextIndex = i;
					}
				}
			}

			if ( nextIndex !== null ) {
				// Why using trigger() instead of a direct method to select the
				// index? Because we don't what is the exact action to do, it
				// depends if the user is typing on the element or on the popped
				// up menu
				this._optionLis.eq(nextIndex).find("a").trigger( eventType );
			}

			self._typeAhead_timer = window.setTimeout(function() {
				self._typeAhead_timer = undefined;
				self._typeAhead_chars = undefined;
				self._typeAhead_cycling = undefined;
			}, self.options.typeAhead);
		},

		// returns some usefull information, called by callbacks only
		_uiHash: function() {
			var index = this.index();
			return {
				index: index,
				option: $("option", this.element).get(index),
				value: this.element[0].value
			};
		},

		open: function(event) {
			var self = this, o = this.options;
			if ( self.newelement.attr("aria-disabled") != 'true' ) {
				self._closeOthers(event);
				self.newelement.addClass('ui-state-active');

				self.list.attr('aria-hidden', false);
				self.listWrap.addClass( self.widgetBaseClass + '-open' );

				var selected = this._selectedOptionLi();
				if ( o.style == "dropdown" ) {
					self.newelement.removeClass('ui-nocorner-all').addClass('ui-nocorner-top');
				} else {
					// center overflow and avoid flickering
					this.list
						.css("left", -5000)
						.scrollTop( this.list.scrollTop() + selected.position().top - this.list.outerHeight()/2 + selected.outerHeight()/2 )
						.css("left","auto");
				}

				self._refreshPosition();

				var link = selected.find("a");
				if (link.length) link[0].focus();

				self.isOpen = true;
				self._trigger("open", event, self._uiHash());
			}
		},

		close: function(event, retainFocus) {
			if ( this.newelement.is('.ui-state-active') ) {
				this.newelement
					.removeClass('ui-state-active');
				this.listWrap.removeClass(this.widgetBaseClass + '-open');
				this.list.attr('aria-hidden', true);
				if ( this.options.style == "dropdown" ) {
					this.newelement.removeClass('ui-nocorner-top').addClass('ui-nocorner-all');
				}
				if ( retainFocus ) {
					this.newelement.focus();
				}
				this.isOpen = false;
				this._trigger("close", event, this._uiHash());
			}
		},

		change: function(event) {
			this.element.trigger("change");
			this._trigger("change", event, this._uiHash());
		},

		select: function(event) {
			if (this._disabled(event.currentTarget)) { return false; }
			this._trigger("select", event, this._uiHash());
		},

		widget: function() {
			return this.listWrap.add( this.newelementWrap );
		},

		_closeOthers: function(event) {
			$('.' + this.widgetBaseClass + '.ui-state-active').not(this.newelement).each(function() {
				$(this).data('selectelement').selectmenu('close', event);
			});
			$('.' + this.widgetBaseClass + '.ui-state-nohover').trigger('mouseout');
		},

		_toggle: function(event, retainFocus) {
			if ( this.isOpen ) {
				this.close(event, retainFocus);
			} else {
				this.open(event);
			}
		},

		_formatText: function(text) {
			if (this.options.format) {
				text = this.options.format(text);
			} else if (this.options.escapeHtml) {
				text = $('<div />').text(text).html();
			}
			return text;
		},

		_selectedIndex: function() {
			return this.element[0].selectedIndex;
		},

		_selectedOptionLi: function() {
			return this._optionLis.eq(this._selectedIndex());
		},

		_focusedOptionLi: function() {
			return this.list.find('.' + this.widgetBaseClass + '-item-focus');
		},

		_moveSelection: function(amt, recIndex) {
			// do nothing if disabled
			if (!this.options.disabled) {
				var currIndex = parseInt(this._selectedOptionLi().data('index') || 0, 10);
				var newIndex = currIndex + amt;
				// do not loop when using up key

				if (newIndex < 0) {
					newIndex = 0;
				}
				if (newIndex > this._optionLis.size() - 1) {
					newIndex = this._optionLis.size() - 1;
				}
				// Occurs when a full loop has been made
				if (newIndex === recIndex) { return false; }

				if (this._optionLis.eq(newIndex).hasClass( this.namespace + '-state-disabled' )) {
					// if option at newIndex is disabled, call _moveFocus, incrementing amt by one
					(amt > 0) ? ++amt : --amt;
					this._moveSelection(amt, newIndex);
				} else {
					this._optionLis.eq(newIndex).trigger('mouseover').trigger('mouseup');
				}
			}
		},

		_moveFocus: function(amt, recIndex) {
			if (!isNaN(amt)) {
				var currIndex = parseInt(this._focusedOptionLi().data('index') || 0, 10);
				var newIndex = currIndex + amt;
			} else {
				var newIndex = parseInt(this._optionLis.filter(amt).data('index'), 10);
			}

			if (newIndex < 0) {
				newIndex = 0;
			}
			if (newIndex > this._optionLis.size() - 1) {
				newIndex = this._optionLis.size() - 1;
			}

			//Occurs when a full loop has been made
			if (newIndex === recIndex) { return false; }

			var activeID = this.widgetBaseClass + '-item-' + Math.round(Math.random() * 1000);

			this._focusedOptionLi().find('a:eq(0)').attr('id', '');

			if (this._optionLis.eq(newIndex).hasClass( this.namespace + '-state-disabled' )) {
				// if option at newIndex is disabled, call _moveFocus, incrementing amt by one
				(amt > 0) ? ++amt : --amt;
				this._moveFocus(amt, newIndex);
			} else {
				this._optionLis.eq(newIndex).find('a:eq(0)').attr('id',activeID).focus();
			}

			this.list.attr('aria-activedescendant', activeID);
		},

		_scrollPage: function(direction) {
			var numPerPage = Math.floor(this.list.outerHeight() / this._optionLis.first().outerHeight());
			numPerPage = (direction == 'up' ? -numPerPage : numPerPage);
			this._moveFocus(numPerPage);
		},

		_setOption: function(key, value) {
			this.options[key] = value;
			// set
			if (key == 'disabled') {
				if (value) this.close();
				this.element
					.add(this.newelement)
					.add(this.list)[value ? 'addClass' : 'removeClass'](
						this.widgetBaseClass + '-disabled' + ' ' +
						this.namespace + '-state-disabled')
					.attr("aria-disabled", value);
			}
		},

		disable: function(index, type){
				// if options is not provided, call the parents disable function
				if ( typeof( index ) == 'undefined' ) {
					this._setOption( 'disabled', true );
				} else {
					if ( type == "optgroup" ) {
						this._disableOptgroup(index);
					} else {
						this._disableOption(index);
					}
				}
		},

		enable: function(index, type) {
				// if options is not provided, call the parents enable function
				if ( typeof( index ) == 'undefined' ) {
					this._setOption('disabled', false);
				} else {
					if ( type == "optgroup" ) {
						this._enableOptgroup(index);
					} else {
						this._enableOption(index);
					}
				}
		},

		_disabled: function(elem) {
				return $(elem).hasClass( this.namespace + '-state-disabled' );
		},


		_disableOption: function(index) {
				var optionElem = this._optionLis.eq(index);
				if (optionElem) {
					optionElem.addClass(this.namespace + '-state-disabled')
						.find("a").attr("aria-disabled", true);
					this.element.find("option").eq(index).attr("disabled", "disabled");
				}
		},

		_enableOption: function(index) {
				var optionElem = this._optionLis.eq(index);
				if (optionElem) {
					optionElem.removeClass( this.namespace + '-state-disabled' )
						.find("a").attr("aria-disabled", false);
					this.element.find("option").eq(index).removeAttr("disabled");
				}
		},

		_disableOptgroup: function(index) {
				var optGroupElem = this.list.find( 'li.' + this.widgetBaseClass + '-group-' + index );
				if (optGroupElem) {
					optGroupElem.addClass(this.namespace + '-state-disabled')
						.attr("aria-disabled", true);
					this.element.find("optgroup").eq(index).attr("disabled", "disabled");
				}
		},

		_enableOptgroup: function(index) {
				var optGroupElem = this.list.find( 'li.' + this.widgetBaseClass + '-group-' + index );
				if (optGroupElem) {
					optGroupElem.removeClass(this.namespace + '-state-disabled')
						.attr("aria-disabled", false);
					this.element.find("optgroup").eq(index).removeAttr("disabled");
				}
		},

		index: function(newValue) {
			if (arguments.length) {
				if (!this._disabled($(this._optionLis[newValue]))) {
					this.element[0].selectedIndex = newValue;
					this._refreshValue();
				} else {
					return false;
				}
			} else {
				return this._selectedIndex();
			}
		},

		value: function(newValue) {
			if (arguments.length) {
				this.element[0].value = newValue;
				this._refreshValue();
			} else {
				return this.element[0].value;
			}
		},

		_refreshValue: function() {
			var activeClass = (this.options.style == "popup") ? " ui-state-active" : "";
			var activeID = this.widgetBaseClass + '-item-' + Math.round(Math.random() * 1000);
			// deselect previous
			this.list
				.find('.' + this.widgetBaseClass + '-item-selected')
				.removeClass(this.widgetBaseClass + "-item-selected" + activeClass)
				.find('a')
				.attr('aria-selected', 'false')
				.attr('id', '');
			// select new
			this._selectedOptionLi()
				.addClass(this.widgetBaseClass + "-item-selected" + activeClass)
				.find('a')
				.attr('aria-selected', 'true')
				.attr('id', activeID);

			// toggle any class brought in from option
			var currentOptionClasses = (this.newelement.data('optionClasses') ? this.newelement.data('optionClasses') : "");
			var newOptionClasses = (this._selectedOptionLi().data('optionClasses') ? this._selectedOptionLi().data('optionClasses') : "");
			this.newelement
				.removeClass(currentOptionClasses)
				.data('optionClasses', newOptionClasses)
				.addClass( newOptionClasses )
				.find('.' + this.widgetBaseClass + '-status')
				.html(
					this._selectedOptionLi()
						.find('a:eq(0)')
						.html()
				);

			this.list.attr('aria-activedescendant', activeID);
		},

		_refreshPosition: function() {
			var o = this.options;

			// if its a pop-up we need to calculate the position of the selected li
			if ( o.style == "popup" && !o.positionOptions.offset ) {
				var selected = this._selectedOptionLi();
				var _offset = "0 " + ( this.list.offset().top  - selected.offset().top - ( this.newelement.outerHeight() + selected.outerHeight() ) / 2);
			}
			this.listWrap
				.removeAttr('style')
				.zIndex( this.element.zIndex() + 1 )
				.position({
					// set options for position plugin
					of: o.positionOptions.of || this.newelement,
					my: o.positionOptions.my,
					at: o.positionOptions.at,
					offset: o.positionOptions.offset || _offset,
					collision: o.positionOptions.collision || (o.style == "popup" ? 'fit' :'flip')
				});
		}
	});

	})(jQuery);



	/**
	 * Cookie plugin
	 *
	 * Copyright (c) 2006 Klaus Hartl (stilbuero.de)
	 * Dual licensed under the MIT and GPL licenses:
	 * http://www.opensource.org/licenses/mit-license.php
	 * http://www.gnu.org/licenses/gpl.html
	 *
	 */

	/**
	 * Create a cookie with the given name and value and other optional parameters.
	 *
	 * @example $.cookie('the_cookie', 'the_value');
	 * @desc Set the value of a cookie.
	 * @example $.cookie('the_cookie', 'the_value', { expires: 7, path: '/', domain: 'jquery.com', secure: true });
	 * @desc Create a cookie with all available options.
	 * @example $.cookie('the_cookie', 'the_value');
	 * @desc Create a session cookie.
	 * @example $.cookie('the_cookie', null);
	 * @desc Delete a cookie by passing null as value. Keep in mind that you have to use the same path and domain
	 *       used when the cookie was set.
	 *
	 * @param String name The name of the cookie.
	 * @param String value The value of the cookie.
	 * @param Object options An object literal containing key/value pairs to provide optional cookie attributes.
	 * @option Number|Date expires Either an integer specifying the expiration date from now on in days or a Date object.
	 *                             If a negative value is specified (e.g. a date in the past), the cookie will be deleted.
	 *                             If set to null or omitted, the cookie will be a session cookie and will not be retained
	 *                             when the the browser exits.
	 * @option String path The value of the path atribute of the cookie (default: path of page that created the cookie).
	 * @option String domain The value of the domain attribute of the cookie (default: domain of page that created the cookie).
	 * @option Boolean secure If true, the secure attribute of the cookie will be set and the cookie transmission will
	 *                        require a secure protocol (like HTTPS).
	 * @type undefined
	 *
	 * @name $.cookie
	 * @cat Plugins/Cookie
	 * @author Klaus Hartl/klaus.hartl@stilbuero.de
	 */

	/**
	 * Get the value of a cookie with the given name.
	 *
	 * @example $.cookie('the_cookie');
	 * @desc Get the value of a cookie.
	 *
	 * @param String name The name of the cookie.
	 * @return The value of the cookie.
	 * @type String
	 *
	 * @name $.cookie
	 * @cat Plugins/Cookie
	 * @author Klaus Hartl/klaus.hartl@stilbuero.de
	 */
	jQuery.cookie = function(name, value, options) {
	    if (typeof value != 'undefined') { // name and value given, set cookie
	        options = options || {};
	        if (value === null) {
	            value = '';
	            options.expires = -1;
	        }
	        var expires = '';
	        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
	            var date;
	            if (typeof options.expires == 'number') {
	                date = new Date();
	                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
	            } else {
	                date = options.expires;
	            }
	            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
	        }
	        // CAUTION: Needed to parenthesize options.path and options.domain
	        // in the following expressions, otherwise they evaluate to undefined
	        // in the packed version for some reason...
	        var path = options.path ? '; path=' + (options.path) : '';
	        var domain = options.domain ? '; domain=' + (options.domain) : '';
	        var secure = options.secure ? '; secure' : '';
	        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
	    } else { // only name given, get cookie
	        var cookieValue = null;
	        if (document.cookie && document.cookie != '') {
	            var cookies = document.cookie.split(';');
	            for (var i = 0; i < cookies.length; i++) {
	                var cookie = jQuery.trim(cookies[i]);
	                // Does this cookie string begin with the name we want?
	                if (cookie.substring(0, name.length + 1) == (name + '=')) {
	                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
	                    break;
	                }
	            }
	        }
	        return cookieValue;
	    }
	};

	var videos_array=new Array();
	/*	SWFObject v2.2 <http://code.google.com/p/swfobject/>
	is released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
	*/
	var swfobject=function(){var D="undefined",r="object",S="Shockwave Flash",W="ShockwaveFlash.ShockwaveFlash",q="application/x-shockwave-flash",R="SWFObjectExprInst",x="onreadystatechange",O=window,j=document,t=navigator,T=false,U=[h],o=[],N=[],I=[],l,Q,E,B,J=false,a=false,n,G,m=true,M=function(){var aa=typeof j.getElementById!=D&&typeof j.getElementsByTagName!=D&&typeof j.createElement!=D,ah=t.userAgent.toLowerCase(),Y=t.platform.toLowerCase(),ae=Y?/win/.test(Y):/win/.test(ah),ac=Y?/mac/.test(Y):/mac/.test(ah),af=/webkit/.test(ah)?parseFloat(ah.replace(/^.*webkit\/(\d+(\.\d+)?).*$/,"$1")):false,X=!+"\v1",ag=[0,0,0],ab=null;if(typeof t.plugins!=D&&typeof t.plugins[S]==r){ab=t.plugins[S].description;if(ab&&!(typeof t.mimeTypes!=D&&t.mimeTypes[q]&&!t.mimeTypes[q].enabledPlugin)){T=true;X=false;ab=ab.replace(/^.*\s+(\S+\s+\S+$)/,"$1");ag[0]=parseInt(ab.replace(/^(.*)\..*$/,"$1"),10);ag[1]=parseInt(ab.replace(/^.*\.(.*)\s.*$/,"$1"),10);ag[2]=/[a-zA-Z]/.test(ab)?parseInt(ab.replace(/^.*[a-zA-Z]+(.*)$/,"$1"),10):0}}else{if(typeof O.ActiveXObject!=D){try{var ad=new ActiveXObject(W);if(ad){ab=ad.GetVariable("$version");if(ab){X=true;ab=ab.split(" ")[1].split(",");ag=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}}catch(Z){}}}return{w3:aa,pv:ag,wk:af,ie:X,win:ae,mac:ac}}(),k=function(){if(!M.w3){return}if((typeof j.readyState!=D&&j.readyState=="complete")||(typeof j.readyState==D&&(j.getElementsByTagName("body")[0]||j.body))){f()}if(!J){if(typeof j.addEventListener!=D){j.addEventListener("DOMContentLoaded",f,false)}if(M.ie&&M.win){j.attachEvent(x,function(){if(j.readyState=="complete"){j.detachEvent(x,arguments.callee);f()}});if(O==top){(function(){if(J){return}try{j.documentElement.doScroll("left")}catch(X){setTimeout(arguments.callee,0);return}f()})()}}if(M.wk){(function(){if(J){return}if(!/loaded|complete/.test(j.readyState)){setTimeout(arguments.callee,0);return}f()})()}s(f)}}();function f(){if(J){return}try{var Z=j.getElementsByTagName("body")[0].appendChild(C("span"));Z.parentNode.removeChild(Z)}catch(aa){return}J=true;var X=U.length;for(var Y=0;Y<X;Y++){U[Y]()}}function K(X){if(J){X()}else{U[U.length]=X}}function s(Y){if(typeof O.addEventListener!=D){O.addEventListener("load",Y,false)}else{if(typeof j.addEventListener!=D){j.addEventListener("load",Y,false)}else{if(typeof O.attachEvent!=D){i(O,"onload",Y)}else{if(typeof O.onload=="function"){var X=O.onload;O.onload=function(){X();Y()}}else{O.onload=Y}}}}}function h(){if(T){V()}else{H()}}function V(){var X=j.getElementsByTagName("body")[0];var aa=C(r);aa.setAttribute("type",q);var Z=X.appendChild(aa);if(Z){var Y=0;(function(){if(typeof Z.GetVariable!=D){var ab=Z.GetVariable("$version");if(ab){ab=ab.split(" ")[1].split(",");M.pv=[parseInt(ab[0],10),parseInt(ab[1],10),parseInt(ab[2],10)]}}else{if(Y<10){Y++;setTimeout(arguments.callee,10);return}}X.removeChild(aa);Z=null;H()})()}else{H()}}function H(){var ag=o.length;if(ag>0){for(var af=0;af<ag;af++){var Y=o[af].id;var ab=o[af].callbackFn;var aa={success:false,id:Y};if(M.pv[0]>0){var ae=c(Y);if(ae){if(F(o[af].swfVersion)&&!(M.wk&&M.wk<312)){w(Y,true);if(ab){aa.success=true;aa.ref=z(Y);ab(aa)}}else{if(o[af].expressInstall&&A()){var ai={};ai.data=o[af].expressInstall;ai.width=ae.getAttribute("width")||"0";ai.height=ae.getAttribute("height")||"0";if(ae.getAttribute("class")){ai.styleclass=ae.getAttribute("class")}if(ae.getAttribute("align")){ai.align=ae.getAttribute("align")}var ah={};var X=ae.getElementsByTagName("param");var ac=X.length;for(var ad=0;ad<ac;ad++){if(X[ad].getAttribute("name").toLowerCase()!="movie"){ah[X[ad].getAttribute("name")]=X[ad].getAttribute("value")}}P(ai,ah,Y,ab)}else{p(ae);if(ab){ab(aa)}}}}}else{w(Y,true);if(ab){var Z=z(Y);if(Z&&typeof Z.SetVariable!=D){aa.success=true;aa.ref=Z}ab(aa)}}}}}function z(aa){var X=null;var Y=c(aa);if(Y&&Y.nodeName=="OBJECT"){if(typeof Y.SetVariable!=D){X=Y}else{var Z=Y.getElementsByTagName(r)[0];if(Z){X=Z}}}return X}function A(){return !a&&F("6.0.65")&&(M.win||M.mac)&&!(M.wk&&M.wk<312)}function P(aa,ab,X,Z){a=true;E=Z||null;B={success:false,id:X};var ae=c(X);if(ae){if(ae.nodeName=="OBJECT"){l=g(ae);Q=null}else{l=ae;Q=X}aa.id=R;if(typeof aa.width==D||(!/%$/.test(aa.width)&&parseInt(aa.width,10)<310)){aa.width="310"}if(typeof aa.height==D||(!/%$/.test(aa.height)&&parseInt(aa.height,10)<137)){aa.height="137"}j.title=j.title.slice(0,47)+" - Flash Player Installation";var ad=M.ie&&M.win?"ActiveX":"PlugIn",ac="MMredirectURL="+O.location.toString().replace(/&/g,"%26")+"&MMplayerType="+ad+"&MMdoctitle="+j.title;if(typeof ab.flashvars!=D){ab.flashvars+="&"+ac}else{ab.flashvars=ac}if(M.ie&&M.win&&ae.readyState!=4){var Y=C("div");X+="SWFObjectNew";Y.setAttribute("id",X);ae.parentNode.insertBefore(Y,ae);ae.style.display="none";(function(){if(ae.readyState==4){ae.parentNode.removeChild(ae)}else{setTimeout(arguments.callee,10)}})()}u(aa,ab,X)}}function p(Y){if(M.ie&&M.win&&Y.readyState!=4){var X=C("div");Y.parentNode.insertBefore(X,Y);X.parentNode.replaceChild(g(Y),X);Y.style.display="none";(function(){if(Y.readyState==4){Y.parentNode.removeChild(Y)}else{setTimeout(arguments.callee,10)}})()}else{Y.parentNode.replaceChild(g(Y),Y)}}function g(ab){var aa=C("div");if(M.win&&M.ie){aa.innerHTML=ab.innerHTML}else{var Y=ab.getElementsByTagName(r)[0];if(Y){var ad=Y.childNodes;if(ad){var X=ad.length;for(var Z=0;Z<X;Z++){if(!(ad[Z].nodeType==1&&ad[Z].nodeName=="PARAM")&&!(ad[Z].nodeType==8)){aa.appendChild(ad[Z].cloneNode(true))}}}}}return aa}function u(ai,ag,Y){var X,aa=c(Y);if(M.wk&&M.wk<312){return X}if(aa){if(typeof ai.id==D){ai.id=Y}if(M.ie&&M.win){var ah="";for(var ae in ai){if(ai[ae]!=Object.prototype[ae]){if(ae.toLowerCase()=="data"){ag.movie=ai[ae]}else{if(ae.toLowerCase()=="styleclass"){ah+=' class="'+ai[ae]+'"'}else{if(ae.toLowerCase()!="classid"){ah+=" "+ae+'="'+ai[ae]+'"'}}}}}var af="";for(var ad in ag){if(ag[ad]!=Object.prototype[ad]){af+='<param name="'+ad+'" value="'+ag[ad]+'" />'}}aa.outerHTML='<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"'+ah+">"+af+"</object>";N[N.length]=ai.id;X=c(ai.id)}else{var Z=C(r);Z.setAttribute("type",q);for(var ac in ai){if(ai[ac]!=Object.prototype[ac]){if(ac.toLowerCase()=="styleclass"){Z.setAttribute("class",ai[ac])}else{if(ac.toLowerCase()!="classid"){Z.setAttribute(ac,ai[ac])}}}}for(var ab in ag){if(ag[ab]!=Object.prototype[ab]&&ab.toLowerCase()!="movie"){e(Z,ab,ag[ab])}}aa.parentNode.replaceChild(Z,aa);X=Z}}return X}function e(Z,X,Y){var aa=C("param");aa.setAttribute("name",X);aa.setAttribute("value",Y);Z.appendChild(aa)}function y(Y){var X=c(Y);if(X&&X.nodeName=="OBJECT"){if(M.ie&&M.win){X.style.display="none";(function(){if(X.readyState==4){b(Y)}else{setTimeout(arguments.callee,10)}})()}else{X.parentNode.removeChild(X)}}}function b(Z){var Y=c(Z);if(Y){for(var X in Y){if(typeof Y[X]=="function"){Y[X]=null}}Y.parentNode.removeChild(Y)}}function c(Z){var X=null;try{X=j.getElementById(Z)}catch(Y){}return X}function C(X){return j.createElement(X)}function i(Z,X,Y){Z.attachEvent(X,Y);I[I.length]=[Z,X,Y]}function F(Z){var Y=M.pv,X=Z.split(".");X[0]=parseInt(X[0],10);X[1]=parseInt(X[1],10)||0;X[2]=parseInt(X[2],10)||0;return(Y[0]>X[0]||(Y[0]==X[0]&&Y[1]>X[1])||(Y[0]==X[0]&&Y[1]==X[1]&&Y[2]>=X[2]))?true:false}function v(ac,Y,ad,ab){if(M.ie&&M.mac){return}var aa=j.getElementsByTagName("head")[0];if(!aa){return}var X=(ad&&typeof ad=="string")?ad:"screen";if(ab){n=null;G=null}if(!n||G!=X){var Z=C("style");Z.setAttribute("type","text/css");Z.setAttribute("media",X);n=aa.appendChild(Z);if(M.ie&&M.win&&typeof j.styleSheets!=D&&j.styleSheets.length>0){n=j.styleSheets[j.styleSheets.length-1]}G=X}if(M.ie&&M.win){if(n&&typeof n.addRule==r){n.addRule(ac,Y)}}else{if(n&&typeof j.createTextNode!=D){n.appendChild(j.createTextNode(ac+" {"+Y+"}"))}}}function w(Z,X){if(!m){return}var Y=X?"visible":"hidden";if(J&&c(Z)){c(Z).style.visibility=Y}else{v("#"+Z,"visibility:"+Y)}}function L(Y){var Z=/[\\\"<>\.;]/;var X=Z.exec(Y)!=null;return X&&typeof encodeURIComponent!=D?encodeURIComponent(Y):Y}var d=function(){if(M.ie&&M.win){window.attachEvent("onunload",function(){var ac=I.length;for(var ab=0;ab<ac;ab++){I[ab][0].detachEvent(I[ab][1],I[ab][2])}var Z=N.length;for(var aa=0;aa<Z;aa++){y(N[aa])}for(var Y in M){M[Y]=null}M=null;for(var X in swfobject){swfobject[X]=null}swfobject=null})}}();return{registerObject:function(ab,X,aa,Z){if(M.w3&&ab&&X){var Y={};Y.id=ab;Y.swfVersion=X;Y.expressInstall=aa;Y.callbackFn=Z;o[o.length]=Y;w(ab,false)}else{if(Z){Z({success:false,id:ab})}}},getObjectById:function(X){if(M.w3){return z(X)}},embedSWF:function(ab,ah,ae,ag,Y,aa,Z,ad,af,ac){var X={success:false,id:ah};if(M.w3&&!(M.wk&&M.wk<312)&&ab&&ah&&ae&&ag&&Y){w(ah,false);K(function(){ae+="";ag+="";var aj={};if(af&&typeof af===r){for(var al in af){aj[al]=af[al]}}aj.data=ab;aj.width=ae;aj.height=ag;var am={};if(ad&&typeof ad===r){for(var ak in ad){am[ak]=ad[ak]}}if(Z&&typeof Z===r){for(var ai in Z){if(typeof am.flashvars!=D){am.flashvars+="&"+ai+"="+Z[ai]}else{am.flashvars=ai+"="+Z[ai]}}}if(F(Y)){var an=u(aj,am,ah);if(aj.id==ah){w(ah,true)}X.success=true;X.ref=an}else{if(aa&&A()){aj.data=aa;P(aj,am,ah,ac);return}else{w(ah,true)}}if(ac){ac(X)}})}else{if(ac){ac(X)}}},switchOffAutoHideShow:function(){m=false},ua:M,getFlashPlayerVersion:function(){return{major:M.pv[0],minor:M.pv[1],release:M.pv[2]}},hasFlashPlayerVersion:F,createSWF:function(Z,Y,X){if(M.w3){return u(Z,Y,X)}else{return undefined}},showExpressInstall:function(Z,aa,X,Y){if(M.w3&&A()){P(Z,aa,X,Y)}},removeSWF:function(X){if(M.w3){y(X)}},createCSS:function(aa,Z,Y,X){if(M.w3){v(aa,Z,Y,X)}},addDomLoadEvent:K,addLoadEvent:s,getQueryParamValue:function(aa){var Z=j.location.search||j.location.hash;if(Z){if(/\?/.test(Z)){Z=Z.split("?")[1]}if(aa==null){return L(Z)}var Y=Z.split("&");for(var X=0;X<Y.length;X++){if(Y[X].substring(0,Y[X].indexOf("="))==aa){return L(Y[X].substring((Y[X].indexOf("=")+1)))}}}return""},expressInstallCallback:function(){if(a){var X=c(R);if(X&&l){X.parentNode.replaceChild(l,X);if(Q){w(Q,true);if(M.ie&&M.win){l.style.display="block"}}if(E){E(B)}}a=false}}}}();
	/*******************************************************************************
	 *
	 * ParsedQueryString version 1.0
	 * Copyright 2007, Jeff Mott <Mott.Jeff@gmail.com>. All rights reserved.
	 *
	 * Redistribution and use in source and binary forms with or without
	 * modification are permitted provided that the above copyright notice,
	 * this condition, and the following disclaimer are retained.
	 *
	 * THIS SOFTWARE IS PROVIDED AS IS, AND ANY EXPRESS OR IMPLIED WARRANTIES,
	 * INCLUDING BUT NOT LIMITED TO THE IMPLIED WARRANTIES OF MERCHANTABILITY AND
	 * FITNESS FOR A PARTICULAR PURPOSE, ARE DISCLAIMED. IN NO EVENT SHALL THE
	 * COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
	 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING BUT NOT
	 * LIMITED TO PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR
	 * PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF
	 * LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING
	 * NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
	 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
	 *
	 ******************************************************************************/

	function ParsedQueryString() {
		this._init();
	}

	ParsedQueryString.version = '1.0';

	ParsedQueryString.prototype =
	{
		_init:
			function ()
			{
				this._parameters = {};

				if (location.search.length <= 1)
					return;
				var pairs = location.search.substr(1).split(/[&;]/);
				for (var i = 0; i < pairs.length; i++)
				{
					var pair = pairs[i].split(/=/);
					var name = this._decodeURL(pair[0]);
					if (Boolean(pair[1]))
					{
						var value = this._decodeURL(pair[1]);
						if (Boolean(this._parameters[name]))
							this._parameters[name].push(value);
						else
							this._parameters[name] = [value];
					}
				}
			},

		_decodeURL:
			function (url) {
				return decodeURIComponent(url.replace(/\+/g, " "));
			},

		param:
			function (name)
			{
				if (Boolean(this._parameters[name]))
					return this._parameters[name][0];
				else
					return "";
			},

		params:
			function (name)
			{
				if (Boolean(name))
				{
					if (Boolean(this._parameters[name]))
					{
						var values = [];
						for (var i = 0; i < this._parameters[name].length; i++)
							values.push(this._parameters[name][i]);
						return values;
					}
					else
						return [];
				}
				else
				{
					var names = [];
					for (var name in this._parameters)
						names.push(name);
					return names;
				}
			}
	};


	function init_player()
	{


					to_append = '<h3><a href="#">In gallery</a></h3>';
					to_append += '<div>';
					$(xml).find('same_gallery_item').each(function loopingItems(value)
					{
						var obj={title:$(this).find("title").text(), mp4:$(this).find("mp4").text(), ogv:$(this).find("ogv").text(),webm:$(this).find("webm").text(), id:$(this).find("id").text(), description_player:$(this).find("description").html()};
						videos_array.push(obj);
						to_append += '<div class="player_accordion"><a ><li id="item">'+obj.title+'</li></a></div>';
					});
					to_append += '</div>';
					/*
					to_append += '<h3><a href="#">Same user</a></h3>';
					to_append += '<div>';
					$(xml).find('same_user_item').each(function loopingItems(value)
					{
						var obj={title:$(this).find("title").text(), mp4:$(this).find("mp4").text(), ogv:$(this).find("ogv").text(), webm:$(this).find("webm").text(), description_player:$(this).find("description").html()};
						videos_array.push(obj);
						to_append += '<div class="player_accordion"><a ><li id="item">'+obj.title+'</li></a></div>';
					});
					to_append += '</div>';
					*/
					to_append += '<h3><a href="#">Related</a></h3>';
					to_append += '<div>';
					$(xml).find('related_item').each(function loopingItems(value)
					{
						var obj={title:$(this).find("title").text(), mp4:$(this).find("mp4").text(), ogv:$(this).find("ogv").text(), webm:$(this).find("webm").text(), id:$(this).find("id").text(), description_player:$(this).find("description").html()};
						videos_array.push(obj);
						to_append += '<div class="player_accordion"><a ><li id="item">'+obj.title+'</li></a></div>';
					});
					to_append += '</div>';


					$("#description_player").html(videos_array[0].description_player);
					$("#playlist").append(to_append);
					$("#playlist").accordion({
						header : "h3",
						animated:false
					});
					addListeners();

	}

	function addListeners()
	{
		$('#playlist li').each(function looping(index)
		{
			$(this).click(function onItemClick()
			{
				$.ajax({
			type : "GET",
			url : site_url + 'index.php?route=users_interaction&action=video_details_inner&id='+videos_array[index].id,
			success : function(response) {
				$("#player").html(response);
							$("#description_player").html(videos_array[index].description_player);


			}
			});
			});
		});

	}

	var audios_array=new Array();

	function init_player_audio()
	{

					to_append = '<h3><a href="#">Same user</a></h3>';
					to_append += '<div>';
					$(xml).find('same_gallery_item').each(function loopingItems(value)
					{
						var obj={title:$(this).find("title").text(), mp3:$(this).find("mp3").text(), ogg:$(this).find("ogg").text(),mp4:$(this).find("mp4").text(), id:$(this).find("id").text(), description_player:$(this).find("description").html()};
						audios_array.push(obj);
						to_append += '<div class="player_accordion"><a><li id="item">'+obj.title+'</li></a></div>';
					});
					to_append += '</div>';
						to_append += '<h3><a href="#">Related</a></h3>';
					to_append += '<div>';
					$(xml).find('related_item').each(function loopingItems(value)
					{

						var obj={title:$(this).find("title").text(), mp3:$(this).find("mp3").text(), ogg:$(this).find("ogg").text(), mp4:$(this).find("mp4").text(), id:$(this).find("id").text(), description_player:$(this).find("description").html()};
						audios_array.push(obj);
						to_append += '<div class="player_accordion"><a><li id="item">'+obj.title+'</li></a></div>';
					});

					to_append += '</div>';

		$("#description_player").html(audios_array[0].description_player);
					$("#playlist").append(to_append);
					$("#playlist").accordion({
						header : "h3",
						animated:false
					});
					addListenersAudio();

	}

	function addListenersAudio()
	{
		$('#playlist li').each(function looping(index)
		{
			$(this).click(function onItemClick()
			{
				$.ajax({
			type : "GET",
			url : site_url + 'index.php?route=users_interaction&action=music_details_inner&id='+audios_array[index].id,
			success : function(response) {
				$("#player").html(response);
							$("#description_player").html(audios_array[index].description_player);


			}
			});
			});
		});

	}

	$(function() {

		// Accordion
		$("#my_account_box").collapse();
		if (not_load_middle_default == false) {
			$("#middle_boxes").collapse();
		}

		$("#left_bottom_box").collapse();
		$('#right_bottom_box').collapse();

		$("select").css("background",
				$(".ui-widget-header").css("background-color"));

		$('select#categories').selectmenu({menuWidth: 85,maxHeight:370});
		$('select#theme_selector').selectmenu({menuWidth: 83,maxHeight:370});



		// Tabs

		if (user_logged == '1') {
		/*	$('#tabs').tabs({
				selected : 0,
				select : function(event, ui) {
					if (no_ajax == 'yes') {
						if (ui.tab.rel) {
							location.href = ui.tab.rel;
						}
					}

				}
			});*/
		} else {
			/*$('#tabs').tabs({
				selected : 1,
				select : function(event, ui) {
					if (no_ajax == 'yes') {
						if (ui.tab.rel) {
							location.href = ui.tab.rel;
						}
					}

				}
			});*/
		}

		$('#chat_tabs').tab('show');
		$('#right_bottom_box').collapse();
		$("#full-page-container").show();
		bind_mouseover();
		// Datepicker
		$('.datepicker').datepicker("options", "z-index", "100000000000");

	});

	function bind_chat()
	{
		$("#new_general_message").keydown(function(event) {
		    if (event.keyCode == 13) {
		        send_general_message();
		    }
		});

		}
	function bind_mouseover()
	{
		/*
		$('.ui-widget-header').bind('mouseenter', function() {
			 $(this).addClass('ui-widget-header-over');
			});
		$('.ui-widget-header').bind('mouseleave', function() {
			 $(this).removeClass('ui-widget-header-over');
			});*/
			}
	function change_theme() {
		var theme = $("#theme_selector").val();
		var loader = $("#jquery_ui_theme_loader");
		loader.attr("href", "resources/themes/wn/ui-themes/" + theme
				+ "/jquery-ui-1.8.18.custom.css");
		$.cookie('jquery-ui-theme', theme, {
			expires : 7
		});
		bind_mouseover();

	}

	function change_theme_2(theme) {

		var loader = $("#jquery_ui_theme_loader");
		loader.attr("href", "resources/themes/wn/ui-themes/" + theme
				+ "/jquery-ui-1.8.18.custom.css");
		$.cookie('jquery-ui-theme', theme, {
			expires : 7
		});
		bind_mouseover();

	}

	function interact() {
	action = $("#categories").val();
		if(no_ajax == 'yes')
			{
			if(action == 'trade')
				{
				document.location.href=site_url + 'trade';
				}
			else if (action == 'statuses')
				{
				document.location.href=site_url + 'statuses';

				}
			else
				{
			document.location.href=site_url + 'peopletalk/' . $("#categories").val();
				}
			}
		else
			{
			if(action == 'trade')
			{
				show_center('users','show_trade');
			}
		else if (action == 'statuses')
			{
			show_center('users','show_statuses');

			}
		else
			{
			show_extra_sections($("#categories").val());
			}
			}

	}
	/*
	 * function close_div(id) { $("#" + id).hide('slide', 1000); new_tab =
	 * $(".topmenu").length; $("#tabs ul").append( '<li class="topmenu"
	 * id="topmenu_' + id + '"><a onclick="show_div(\'' + id + '\')">my account</a></li>'); }
	 */

	function show_div(id) {
		$("#" + id).show('slide', 1000);

		$("#topmenu_" + id).remove();
	}

	function show_element(id) {

		$("#" + id).slideToggle();

	}

	function user_interaction(id, type) {
		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=" + type,
			data : {
				'id' : id,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {
				show_notification(response.status);
				hide_loading();
			}
		});

	}

	function clear_user_section() {
		$("#view_user_section").html('');
	}

	function show_notification(message) {
		$("#notifications").html(message);
		// $("#notifications").effect('pulsate', '', 'slow');
	}

	function show_user_notification(message) {
		show_loading();
		$("#notifications").html(message);
		hide_loading();
	}
	function show_loading() {
	//	$("#ps_slider").html('');
		//$("#ps_slider").hide();
	$("#full-page-container").css("opacity","0.8");

		$("#notifications").html('');
		$("#loading").fadeIn(1000);
	}

	function hide_loading() {
		$("#full-page-container").css("opacity","1");
		$("#loading").fadeOut(2000);
	}

	function go_to_top() {
		// $("#full-page-container")scrollTop();
		// return false;

	}

	function logout() {
		show_loading();
		/*
		 * if(no_ajax == 'yes') {
		 * document.location.href='index.php?route=users&action=logout'; } else {
		 */
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=logout",
			success : function(response) {
				hide_loading();
				$("#tabs").hide();
				$("#tabs").remove();
				$("#top").html(response);
				$("#tabs").fadeIn();
				/*$('#tabs').tabs({
					selected : 0
				});*/
				$('select#categories').selectmenu({menuWidth: 85,maxHeight:350});
				$('select#theme_selector').selectmenu({menuWidth: 85,maxHeight:350});
				bind_mouseover();
				$("#my_account").hide(500, function() {
					$("#webcam").remove();
					$("#my_account").remove();
					$.ajax({
						type : "GET",
						url : "index.php?route=users&action=get_my_account",
						success : function(response) {
							$("#left_my_account").html(response);
							$("#my_account").fadeIn();
							$("#my_account").accordion({
								header : "h3",
								fillSpace : true
							});
							hide_loading();

						}
					});

					$.ajax({
						type : "GET",
						url : "index.php?route=chat&action=get_chat",
						success : function(response) {
							$("#chat").hide();
							$("#chat").remove();
							$("#right_chat").html(response);
							$('#chat').tab('show');

						}
					});
				});

				$(document).ready(function() {

					jQuery("#login_form").validationEngine({

						ajaxFormValidation : true,
						onBeforeAjaxFormValidation : beforeCall,
						onAjaxFormComplete : ajaxValidationCallback,

					});

				});

			}
		});
		// }
	}

	function ask_question(id) {

		show_loading();
		clear_user_section();
		$("#view_user_section").dialog(
				{
					modal : true,
					open : function() {
						$(this).load(
								'index.php?route=users_interaction&action=ask_question_form&id='
										+ id);
						hide_loading();
					},
					height : 400,
					width : 520,
					title : 'Ask Question',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});

	}

	function ask_question_2(id) {
		show_loading();
		if ($.trim($("#ask_question_textarea").val()) == '') {
			show_notification(all_fields_required);
			hide_loading();
			return false;
		}
		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=ask_question",
			data : {
				'id' : id,
				'rh' : r_h,
				'question' : $("#ask_question_textarea").val()
			},
			dataType : 'json',
			success : function(response) {

				show_notification(response.status);
				$("#view_user_section").dialog('close');
				clear_user_section();
				hide_loading();
			}
		});
	}

	function show_center(route, type) {
		hide_details();
		show_loading();
		$.ajax({
			type : "GET",
			url : "index.php?route=" + route + "&action=" + type,
			data : {
				'rh' : r_h
			},
			success : function(response) {

				if (!$("#middle_default").hasClass('middle_small')) {
					// $('#middle_default').animate({
					// width: ['toggle', 'swing'],
					// height: ['toggle', 'swing'],
					// },500, 'linear', function() {

					/*
					 * $("#middle_default").prependTo($("#left_default")).css({ top :
					 * 'auto', left : 'auto' }).addClass('middle_small');
					 * $("#middle_default").show();
					 */
					// });
				}

				//$("#middle").hide();
				$("#middle").html('');
				$("#middle").html(response);
				//$("#middle").fadeIn(500);
				$("#" + type).collapse();
				bind_mouseover();
				hide_loading();

			}
		});

	}
	function show_profile() {

		hide_details();
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=profile",
			data : {
				'rh' : r_h
			},
			success : function(response) {

				$("#middle").html(response);
				$("#profile").collapse();
				$("#extra_fields").collapse();
			}
		});

	}

	function invite_to_event(id) {
		show_loading();
		clear_user_section();
		$("#view_user_section").dialog(
				{
					modal : true,
					open : function() {
						$(this).load(
								"index.php?route=users_interaction&action=get_events_to_invite&id="
										+ id + "&rh=" + r_h);
						hide_loading();
					},
					height : 200,
					width : 520,
					title : 'Invite to event',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});

	}

	function invite_to_event_2(id) {
		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=invite_to_event",
			data : {
				'id' : id,
				'rh' : r_h,
				'event' : $("#invite_to_event_id_" + id).val()
			},
			dataType : 'json',
			success : function(response) {

				show_notification(response.status);
				$("#view_user_section").dialog('close');
				hide_loading();
			}
		});
	}

	function show_message(id, status) {
		$("#message_text_" + id).toggle('clip', {}, 300);
		// show_loading();
		if (status == '0') {
			$.ajax({
				type : "POST",
				url : "index.php?route=users_interaction&action=mark_message_read",
				data : {
					'id' : id,
					'rh' : r_h
				},
				dataType : 'json',
				success : function(response) {

					// show_notification(response.status);

					hide_loading();
				}
			});
		}

	}
	function delete_message(id) {

		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=delete_message",
			data : {
				'id' : id,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {

				show_notification(response.status);
				$("#message_" + id).fadeOut();
				hide_loading();
			}
		});

	}

	function view_user_section(route, action, id, dialog_title) {

		show_loading();
		clear_user_section();
		/*$.ajax({
			type : "POST",
			url : "index.php?route=" + route + "&action=" + action,
			data : {
				'id' : id,
				'rh' : r_h
			},
			// dataType : 'json',
			success : function(response) {
	*/
				//$("#view_user_section").html(response);
				$("#view_user_section").dialog({
					  open: function(event, ui) {
						  $.ajax({
								type : "POST",
								url : "index.php?route=" + route + "&action=" + action,
								data : {
									'id' : id,
									'rh' : r_h
								},
								success : function(response) {

												$("#view_user_section").html(response);
								}});
					  },
					title : dialog_title,
					width : '1200',
					height : '600',
					resizable : false,
					modal : true,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});

				hide_loading();
			//}
		//});

	}

	function change_profile_picture() {
		$("#change_profile_picture").dialog({
			title : 'Upload Profile picture',
			modal : true,
			width : '300',
			height : '200',
			resizable : false,
			show : {
				effect : 'fade'
			},
			zIndex : '3000',
			hide : {
				effect : 'fade'
			}
		});

	}

	function send_message(id) {

		show_loading();
		clear_user_section();
		$("#view_user_section").dialog(
				{
					modal : true,
					open : function() {
						$(this).load(
								'index.php?route=users_interaction&action=send_message_form&id='
										+ id);

						hide_loading();
					},
					height : 400,
					width : 520,
					title : 'Send message',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});

	}

	function send_message_2(id) {
		show_loading();
		if ($.trim($("#message_title").val()) == ''
				|| $.trim($("#message_text").val()) == '') {
			show_notification(all_fields_required);
			hide_loading();
			return false;
		}
		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=send_message",
			data : {
				'id' : id,
				'title' : $("#message_title").val(),
				'message' : $("#message_text").val(),
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {

				show_notification(response.status);
				$("#view_user_section").dialog('close');
				hide_loading();
			}
		});

	}

	function show_user_groups() {

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=user_groups",
			data : {
				'rh' : r_h
			},
			success : function(response) {

				$("#middle").html(response);

			}
		});

	}

	function join_group(id, u_k) {
		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=join_group",
			data : {
				'id' : id,
				'u_k' : u_k,
				'rh' : r_h

			},
			dataType : 'json',
			success : function(response) {

				show_notification(response.status);

				hide_loading();
			}
		});
	}

	function group_details(id) {
		hide_details();
		show_loading();
		$.ajax({
			type : "GET",
			url : "index.php?route=users_interaction&action=group_details",
			data : {
				'id' : id,
				'rh' : r_h
			},
			// dataType : 'json',
			success : function(response) {

				if (response.indexOf('You are not logged in') != -1) {
					show_notification(response);
					hide_loading();
				} else {
					$("#view_groups").html('');
					$("#view_groups").html(response);

					$("#view_groups").show();
					$("#tabs_group_details").tab('show');
					$(".group_details_left").collapse();
					bind_mouseover();
					hide_loading();
				}
			}

		});

	}

	function change_status() {
		// $(".speech_bubble").html('');
		$("#change_status").fadeIn();
	}

	function save_status() {

		$.ajax({
			type : "POST",
			url : "index.php?route=users&action=save_user_status",
			data : {
				'rh' : r_h,
				'status' : $("#status").val()
			},
			success : function(response) {
				status_new = $("#status").val();
				$(".speech_bubble").html('');
				$(".speech_bubble").html(status_new);
				$("#change_status").fadeOut();
			}
		});

	}

	function view_profile(id) {
		hide_details();
		show_loading();
		$("#view_user_section").dialog('close');
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=view_profile",
			data : {
				'id' : id,
				'rh' : r_h
			},
			// dataType : 'json',
			success : function(response) {
				if (response.indexOf('You are not logged in') != -1) {
					show_notification(response);
					hide_loading();
				} else {

					$("#view_top").html('');
					$("#view_top").html(response);
					$("#view_top").show();
					$(".left_profile_page").collapse();
					$("#profile_pictures").tab('show');
					$("#profile_blogs").tab('show');
					$("#profile_events").tab('show');
					$("#profile_groups").tab('show');
					bind_mouseover();
					hide_loading();
				}
			}
		});

	}

	function subscribe_to_pictures(u_k) {
		show_loading();

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=subscribe_to_pictures",
			data : {

				'u_k' : u_k,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {
				show_notification(response.status);
				hide_loading();
			}
		});
	}

	function show_picture(p_id, g_id, g_n, u_k, p_n) {
		// $("#left_sections").html('');
		// $("#galleries_right").html('');
		var width = large_image_width - 100;
		$("#big_picture_gallery").html(
				'<img src="image.php?aoe=1&w=' + width + '&h='
						+ large_image_height + '&zc=1&src=' + u_k + '/photos/' + g_n
						+ '/' + p_n + '" class="large_image">');
		// $("#big_picture_gallery").fadeIn();
		show_loading();
		$
				.ajax({
					type : "GET",
					url : "index.php?route=users_interaction&action=view_pictures_all_comments",
					data : {
						'id' : p_id,
						'g_id' : g_id,
						'rh' : r_h
					},
					// dataType : 'json',
					success : function(response) {
						$("#pictures_comments").html(response);
						$("#details_left").accordion({
							header : "h3",

							fillSpace : true
						});
						tiny_mce();
						hide_loading();
					}
				});

		// $("#galleries_right").fadeOut('slow');

		// $("#big_picture").hide();
		//

	}

	function hide_details() {
		$("#view_top").html('');
		$("#view_top").hide();
		$("#left_sections_top").html('');
		$("#left_sections_top").hide();
		$("#view_groups").html('');
		$("#view_groups").hide();
		$("#middle_top").html('');
		$("#middle_top").hide();
		$("#right_top").html(''); 
		$("#right_top").hide();
		$("#details_right").html();
		$("#details_right").remove();
		$("#details_left").html();
		$("#details_left").remove();
		$("#left_sections").html('');
	}
	function show_picture_details(p_id, g_id, g_n, u_k, p_n) {

		show_loading();
		hide_details();
		$.ajax({
			type : "GET",
			url : 'index.php?route=users_interaction&action=picture_details&id='
					+ p_id,
			data : {
				'rh' : r_h
			},
			success : function(response) {
				$(response).prependTo($("#middle"));
				$("#details_right").collapse();
			}
		});

		$
				.ajax({
					type : "GET",
					url : "index.php?route=users_interaction&action=view_pictures_all_comments",
					data : {
						'id' : p_id,
						'g_id' : g_id,
						'rh' : r_h
					},
					success : function(response) {
						$(response).prependTo($("#left_sections"));
						$("#details_left").collapse();
						tiny_mce();

						hide_loading();

					}
				});

	}

	function subscribe_to_groups(u_k) {
		show_loading();

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=subscribe_to_groups",
			data : {

				'u_k' : u_k,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {
				show_notification(response.status);
				hide_loading();
			}
		});
	}

	function subscribe_to_events(u_k) {
		show_loading();

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=subscribe_to_events",
			data : {

				'u_k' : u_k,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {
				show_notification(response.status);
				hide_loading();
			}
		});
	}

	function subscribe_to_blog(u_k) {
		show_loading();

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=subscribe_to_blog",
			data : {

				'u_k' : u_k,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {
				show_notification(response.status);
				hide_loading();
			}
		});
	}

	function show_group_profile_page(id, u_k) {

		show_loading();
		// $("#view_groups_profile_page").html('');
		$
				.ajax({
					type : "POST",
					url : "index.php?route=users_content&action=view_group",
					data : {
						'id' : id,
						'u_k' : u_k,
						'rh' : r_h
					},

					success : function(response) {

						$("#view_groups_profile_page")
								.dialog(
										{
											open : function(event, ui) {
												// $("#profile_page_groups_comments").html(response);
												$("#groups_profile_page").html(
														response);
												$
														.ajax({
															type : "POST",
															url : "index.php?route=users_interaction&action=view_group_comments",
															data : {
																'id' : id,
																'u_k' : u_k,
																'rh' : r_h
															},

															success : function(
																	response) {
																$(
																		"#groups_comments")
																		.html(
																				response);
															}
														});

											}
										}, {
											title : 'Group',
											width : '1000',
											height : '600',
											resizable : false,
											show : {
												effect : 'fade'
											},
											zIndex : '3000',
											hide : {
												effect : 'fade'
											}
										});

						// $("#groups_right").html(response);
						hide_loading();
					}
				});

	}

	function show_blog_details(id, u_k) {

		show_loading();
		hide_details();
		$.ajax({
			type : "GET",
			url : 'index.php?route=users_content&action=view_blog',
			data : {
				'id' : id,
				'u_k' : u_k,
				'rh' : r_h
			},
			success : function(response) {
				$(response).prependTo($("#middle"));
				$("#details_right").collapse();
			}
		});

		$.ajax({
			type : "GET",
			url : "index.php?route=users_interaction&action=view_blog_comments",
			data : {

				'rh' : r_h,
				'id' : id
			},
			success : function(response) {
				$(response).prependTo($("#left_sections"));
				$("#details_left").collapse();
				tiny_mce();
				hide_loading();

			}
		});

	}

	function show_event_details(id, u_k) {

		show_loading();
		hide_details();
		$.ajax({
			type : "GET",
			url : 'index.php?route=users_content&action=view_event',
			data : {
				'id' : id,
				'u_k' : u_k,
				'rh' : r_h
			},
			success : function(response) {
				$(response).prependTo($("#middle"));
				$("#details_right").collapse();
			}
		});

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=view_event_comments",
			data : {

				'rh' : r_h,
				'id' : id
			},
			success : function(response) {
				$(response).prependTo($("#left_sections"));
				$("#details_left").collapse();
				tiny_mce();
				hide_loading();
			}
		});

	}

	function show_home() {
		show_loading();
		hide_details();

		$.ajax({
			type : "POST",
			url : "index.php?route=index&action=home",
			data : {
				'rh' : r_h
			},
			success : function(response) {

				$("#middle").hide();
				$("#middle").html('');
				$("#middle").html(response);
				$("#middle").fadeIn(500);
				$("#middle_boxes").accordion({
					header : "h3",

					fillSpace : true
				});
				$("#middle_matches").collapse();
				bind_mouseover();
				hide_loading();
			}
		});

	}

	function music_details(id, user) {

		show_loading();
		hide_details();
		$.ajax({
			type : "GET",
			url : "index.php?route=users_interaction&action=music_details",
			data : {
				'id' : id,
				'user' : user,
				'rh' : r_h
			},
			success : function(response) {
				$(response).prependTo($("#middle"));
			}
		});

		$.ajax({
			type : "GET",
			url : "index.php?route=users_interaction&action=music_files_comments",
			data : {
				'id' : id,
				'user' : user,
				'rh' : r_h
			},
			success : function(response) {
				$(response).prependTo($("#left_sections"));
				$("#left_details").accordion({
					header : "h3",

					fillSpace : true
				});
				tiny_mce();
				hide_loading();
			}
		});

	}

	function subscribe_to_video(u_k) {
		show_loading();

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=subscribe_to_videos",
			data : {

				'u_k' : u_k,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {
				show_notification(response.status);
				hide_loading();
			}
		});
	}


	function video_details(id, user) {

		show_loading();
		hide_details();
		$.ajax({
			type : "GET",
			url : "index.php?route=users_interaction&action=video_details",
			data : {
				'id' : id,
				'user' : user,
				'rh' : r_h
			},
			success : function(response) {
				$(response).prependTo($("#middle"));
			}
		});

		$.ajax({
			type : "GET",
			url : "index.php?route=users_interaction&action=video_comments",
			data : {
				'id' : id,
				'user' : user,
				'rh' : r_h
			},
			success : function(response) {
				$(response).prependTo($("#left_sections"));
				$("#left_details").accordion({
					header : "h3",

					fillSpace : true
				});
				tiny_mce();

				hide_loading();
			}
		});

	}

	function view_video_comments(id) {

		show_loading();

		$
				.ajax({
					type : "POST",
					url : "index.php?route=users_interaction&action=view_video_files_comments",
					data : {
						'id' : id,
						'u_k' : u_k,
						'rh' : r_h
					},

					success : function(response) {
						$("#video_comments").html(response);
					}
				});
	}

	function add_video_comment(video_id) {
		show_loading();
		if ($.trim($("#video_comment").val()) == '') {
			show_notification(comment_empty);
			hide_loading();
			return false;
		}

		$
				.ajax({
					type : "POST",
					url : "index.php?route=users_interaction&action=add_video_comment",
					data : {

						'rh' : r_h,
						'id' : video_id,
						'comment' : $("#video_comment").val(),
					},
					dataType : 'json',
					success : function(response) {

						show_notification(response.status);

						$
								.ajax({
									type : "POST",
									url : "index.php?route=users_interaction&action=get_video_comments",
									data : {

										'rh' : r_h,
										'id' : video_id
									},
									success : function(response) {
										$("#comments_list_details").html('');
										$("#comments_list_details").html(response);

										hide_loading();

									}
								});

						hide_loading();
					}
				});
	}

	function add_music_comment(music_id) {
		show_loading();
		if ($.trim($("#music_comment").val()) == '') {
			show_notification(comment_empty);
			hide_loading();
			return false;
		}
		$
				.ajax({
					type : "POST",
					url : "index.php?route=users_interaction&action=add_music_files_comment",
					data : {

						'rh' : r_h,
						'id' : music_id,
						'comment' : $("#music_comment").val(),
					},
					dataType : 'json',
					success : function(response) {

						show_notification(response.status);

						$
								.ajax({
									type : "POST",
									url : "index.php?route=users_interaction&action=get_music_files_comments",
									data : {

										'rh' : r_h,
										'id' : music_id
									},
									success : function(response) {

										$("#comments_list_details").html('');
										$("#comments_list_details").html(response);

										hide_loading();

									}
								});

						hide_loading();
					}
				});
	}

	function subscribe_to_music(u_k) {
		show_loading();

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=subscribe_to_music",
			data : {

				'u_k' : u_k,
				'rh' : r_h
			},
			dataType : 'json',
			success : function(response) {
				show_notification(response.status);
				hide_loading();
			}
		});
	}


	function edit_video(id, g_id) {
		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users_content&action=edit_video",
			data : {

				'rh' : r_h,
				'id' : id,
				'title' : $("#title_" + id).val(),
				'description' : $("#description_" + id).val(),
				'tags' : $("#tags_" + id).val(),
				'g_id' : g_id
			},
			dataType : 'json',
			success : function(response) {

				show_notification(response.status);
				hide_loading();
			}
		});
	}
	function edit_music(id, g_id) {
		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users_content&action=edit_music",
			data : {

				'rh' : r_h,
				'id' : id,
				'title' : $("#title_" + id).val(),
				'description' : $("#description_" + id).val(),
				'tags' : $("#tags_" + id).val(),
				'g_id' : g_id
			},
			dataType : 'json',
			success : function(response) {

				show_notification(response.status);
				hide_loading();
			}
		});
	}
	function edit_picture(id, g_id) {
		show_loading();
		$.ajax({
			type : "POST",
			url : "index.php?route=users_content&action=edit_picture",
			data : {

				'rh' : r_h,
				'id' : id,
				'title' : $("#title_" + id).val(),
				'description' : $("#description_" + id).val(),
				'tags' : $("#tags_" + id).val(),
				'g_id' : g_id
			},
			dataType : 'json',
			success : function(response) {

				show_notification(response.status);
				hide_loading();
			}
		});
	}

	function trade_details(trade_id, u_k) {

		show_loading();

		hide_details();
		$.ajax({
			type : "POST",
			url : 'index.php?route=users&action=get_trade&trade_id=' + trade_id,
			data : {

			},
			success : function(response) {
				$(response).prependTo($("#middle"));
				$("#details_right").collapse();
				hide_loading();
			}
		});

		$.ajax({
			type : "POST",
			url : "index.php?route=users&action=get_all_trade_questions",
			data : {

				'rh' : r_h,
				'id' : trade_id
			},
			success : function(response) {
				$(response).prependTo($("#left_sections"));
				$("#details_left").collapse();
				tiny_mce();

			}
		});

	}

	function view_trade_questions(id) {

		show_loading();

		$.ajax({
			type : "POST",
			url : "index.php?route=users&action=view_trade_questions",
			data : {
				'id' : id,
				'u_k' : u_k,
				'rh' : r_h
			},

			success : function(response) {
				$("#trade_questions").html(response);
			}
		});
	}

	function view_comments_list_details(type, id) {

		show_loading();

		$
				.ajax({
					type : "POST",
					url : "index.php?route=users_interaction&action=view_comments_list_details&type="
							+ type,
					data : {
						'id' : id,
						'u_k' : u_k,
						'rh' : r_h
					},

					success : function(response) {
						$("#comments_list_details").html(response);
						hide_loading();
					}
				});
	}

	function show_register() {
		clear_user_section();
		$.ajax({
			type : "POST",
			url : "index.php?route=users&action=register_form",
			data : {

			},

			success : function(response) {
				$("#view_user_section").html(response);

				$("#view_user_section").dialog({
					modal : true,

					height : 500,
					width : 650,
					title : 'Register',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					},
					closeOnEscape : true,
					close : function(event, ui) {
						$('#register_form').validationEngine('hideAll');
						$("#view_user_section").html('');
					}
				});

				hide_loading();
			}
		});

	}
	function extra_sections_details(type, id, u_k) {

		show_loading();
		hide_details();
		$
				.ajax({
					type : "GET",
					url : 'index.php?route=users_interaction&action=extra_section_details&type='
							+ type + '&id=' + id,
					data : {
						'rh' : r_h
					},
					success : function(response) {
						$(response).prependTo($("#middle"));
							$("#details_right").collapse();
					}
				});

		$
				.ajax({
					type : "GET",
					url : "index.php?route=users_interaction&action=get_extra_sections_all_comments&type="
							+ type,
					data : {

						'rh' : r_h,
						'id' : id
					},
					success : function(response) {
						$(response).prependTo($("#left_sections"));
						$("#details_left").collapse();
						tiny_mce();
						hide_loading();

					}
				});

	}

	function show_extra_sections(type) {

		show_loading();
		hide_details();
		$.ajax({
			type : "GET",
			url : "index.php?route=users_interaction&action=show_extra_sections",
			data : {
				'type' : type,
				'rh' : r_h
			},
			success : function(response) {

				//$("#middle").hide();
				$("#middle").html('');
				$("#middle").html(response);
			//	$("#middle").fadeIn(500);
				$("#extra_sections").accordion({
					header : "h3",

					fillSpace : true
				});
				bind_mouseover();
				hide_loading();

			}
		});
	}

	function add_extra_sections_comment(type, extra_sections_id) {
		show_loading();
		if ($.trim($("#extra_sections_comment").val()) == '') {
			show_notification(comment_empty);
			hide_loading();
			return false;
		}
		$
				.ajax({
					type : "POST",
					url : "index.php?route=users_interaction&action=add_extra_section_comment",
					data : {

						'rh' : r_h,
						'type' : type,
						'id' : extra_sections_id,
						'comment' : $("#extra_sections_comment").val(),
					},
					dataType : 'json',
					success : function(response) {

						show_notification(response.status);


						$
								.ajax({
									type : "GET",
									url : "index.php?route=users_interaction&action=get_extra_sections_comments",
									data : {
										'type' : type,
										'rh' : r_h,
										'id' : extra_sections_id
									},
									success : function(response) {
										$("#comments_list_details").html('');
										$("#comments_list_details").html(response);

										hide_loading();

									}
								});

					}
				});
	}



	function edit_extra_section_comment(type,id,extra_section_id) {
		show_loading();
	//$("#extra_sections_form").hide();
		$.ajax({
					type : "POST",
					url : "index.php?route=users_interaction&action=edit_extra_section_comment",
					data : {

						'rh' : r_h,
						'id' : id,
						'type':type
					},
					dataType : 'json',
					success : function(response) {

						$('#extra_sections_form').html('<textarea class="comments_textarea validate[required]" id="edit_extra_sections_comment" name="extra_sections_comment" style="display: inline; width: 250px; height: 150px;"></textarea><input type="button" name="submit"	onclick="edit_extra_sections_comment_text(\''+type+'\',\''+id+'\',\''+extra_section_id+'\')"	value="Submit" class="ui-widget-header  input">');
						//$(".wysiwyg").remove();
						$("#extra_sections_comment").css('width','250');
						$("#extra_sections_comment").css('height','150');
						//$("#extra_sections_comment").show();
						$('#edit_extra_sections_comment').val(response.comment);
						tiny_mce();

					}
				});
	}



	function edit_extra_sections_comment_text(type, id,extra_section_id) {
		show_loading();
		if ($.trim($("#edit_extra_sections_comment").val()) == '') {
			show_notification(comment_empty);
			hide_loading();
			return false;
		}

		$.ajax({
					type : "POST",
					url : "index.php?route=users_interaction&action=edit_extra_section_comment_text",
					data : {

						'rh' : r_h,
						'type' : type,
						'id' : id,
						'comment' : $("#edit_extra_sections_comment").val()
					},
					dataType : 'json',
					success : function(response) {

						show_notification(response.status);

						$("#extra_sections_form").html('');
						$("#extra_sections_form").html('<textarea class="comments_textarea validate[required]" id="extra_sections_comment" name="extra_sections_comment"></textarea><input type="button" class="ui-widget-header  input" value="Submit" onclick="add_extra_sections_comment(\''+type+'\',\''+extra_section_id+'\')" name="submit">');
						$("#extra_sections_comment").css('width','250');
						$("#extra_sections_comment").css('height','150');
						//$("#extra_sections_comment").show();
						tiny_mce();
								hide_loading();



					}
				});
	}



	function people_by_country(country) {
		show_loading();
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=people_by_country",
			data : {
				'country' : country,
				'rh' : r_h
			},
			success : function(response) {

				if (!$("#middle_default").hasClass('middle_small')) {
					$('#middle_default').animate({
						width : [ 'toggle', 'swing' ],
						height : [ 'toggle', 'swing' ],
					}, 500, 'linear', function() {

						$("#middle_default").prependTo($("#left_default")).css({
							top : 'auto',
							left : 'auto'
						}).addClass('middle_small');
						$("#middle_default").show('bounce');

					});
				}
				$("#middle").html(response);
				$("#show_people_by_country").accordion({
					header : "h3"
				});
				hide_loading();

			}
		});
	}

	function add_picture_comment(picture_id) {
		show_loading();
		if ($.trim($("#picture_comment").val()) == '') {
			show_notification(all_fields_required);
			hide_loading();
			return false;
		}
		$
				.ajax({
					type : "POST",
					url : "index.php?route=users_interaction&action=add_picture_comment",
					data : {

						'rh' : r_h,
						'id' : picture_id,
						'comment' : $("#picture_comment").val(),
					},
					dataType : 'json',
					success : function(response) {

						show_notification(response.status);

						$
								.ajax({
									type : "GET",
									url : "index.php?route=users_interaction&action=view_pictures_comments",
									data : {

										'rh' : r_h,
										'id' : picture_id
									},
									success : function(response) {
										$("#comments_list_details").html('');
										$("#comments_list_details").html(response);

										hide_loading();

									}
								});

						hide_loading();
					}
				});
	}

	function search() {

		show_loading();
		$.ajax({
			type : "GET",
			url : "index.php?route=users&action=search",
			data : {

				'rh' : r_h,
				'username' : $("#username").val(),
				'featured' : $("#featured").attr('checked'),
				'online' : $("#online").attr('checked'),
				'only_with_picture' : $("#only_with_picture").attr('checked'),
				'male' : $("#male").attr('checked'),
				'female' : $("#female").attr('checked'),
				'age_min' : $("#age_min").val(),
				'age_max' : $("#age_max").val(),
				'country' : $("#search_country").val(),
				'order_by' : $("#order_by").val()
			},
			success : function(response) {

				$("#search_results").html(response);
				$("#search_results_results").collapse();
				$("select").css("background",
						$(".ui-widget-header").css("background-color"));
				hide_loading();
			}
		});

	}

	function show_picture_profile_details(p_id, g_id, g_n, u_k, p_n) {

		// $("#left_sections").html('');
		show_loading();

		$.ajax({
			type : "GET",
			url : 'index.php?route=users_interaction&action=picture_details&id='
					+ p_id,
			data : {
				'rh' : r_h,
				'n_a' : 1
			},
			success : function(response) {
				// $(response).prependTo($("#middle"));
				$("#middle_top").html(response);
				$("#middle_top").fadeIn();
					$("#details_right").collapse();
				big_picture = $("#profile_pic").html();

				big_picture = big_picture.replace('w=' + thumbnail_width, 'w='
						+ width_big_profile_picture);
				big_picture = big_picture.replace('h=' + thumbnail_height, 'h='
						+ height_big_profile_picture);
				$("#right_top").html(big_picture);
				$("#right_top").fadeIn();
			}
		});

		$
				.ajax({
					type : "GET",
					url : "index.php?route=users_interaction&action=view_pictures_all_comments",
					data : {
						'id' : p_id,
						'g_id' : g_id,
						'rh' : r_h
					},
					success : function(response) {
						$("#left_sections_top").html(response);
						$("#left_sections_top").fadeIn();
					$("#details_left").collapse();
						tiny_mce();
						hide_loading();

					}
				});

	}

	function show_blog_profile_details(id, u_k) {

		show_loading();
		$.ajax({
			type : "GET",
			url : 'index.php?route=users_content&action=view_blog',
			data : {
				'id' : id,
				'u_k' : u_k,
				'rh' : r_h,
				'n_a' : 1
			},
			success : function(response) {
				$("#middle_top").html(response);
				$("#middle_top").fadeIn();
					$("#details_right").collapse();
				big_picture = $("#profile_pic").html();

				big_picture = big_picture.replace('w=' + thumbnail_width, 'w='
						+ width_big_profile_picture);
				big_picture = big_picture.replace('h=' + thumbnail_height, 'h='
						+ height_big_profile_picture);
				$("#right_top").html(big_picture);
				$("#right_top").fadeIn();
			}
		});

		$.ajax({
			type : "GET",
			url : "index.php?route=users_interaction&action=view_blog_comments",
			data : {

				'rh' : r_h,
				'id' : id
			},
			success : function(response) {
				$("#left_sections_top").html(response);
				$("#left_sections_top").fadeIn();
				$("#details_left").collapse();ce();
				hide_loading();

			}
		});

	}

	function show_event_profile_details(id, u_k) {

		show_loading();
		$.ajax({
			type : "GET",
			url : 'index.php?route=users_content&action=view_event',
			data : {
				'id' : id,
				'u_k' : u_k,
				'rh' : r_h,
				'n_a' : 1
			},
			success : function(response) {
				$("#middle_top").html(response);
				$("#middle_top").fadeIn();
					$("#details_right").collapse();
				big_picture = $("#profile_pic").html();

				big_picture = big_picture.replace('w=' + thumbnail_width, 'w='
						+ width_big_profile_picture);
				big_picture = big_picture.replace('h=' + thumbnail_height, 'h='
						+ height_big_profile_picture);
				$("#right_top").html(big_picture);
				$("#right_top").fadeIn();

			}
		});

		$.ajax({
			type : "POST",
			url : "index.php?route=users_interaction&action=view_event_comments",
			data : {

				'rh' : r_h,
				'id' : id
			},
			success : function(response) {
				$("#left_sections_top").html(response);
				$("#left_sections_top").fadeIn();
				$("#details_left").collapse();
				tiny_mce();
				hide_loading();
			}
		});

	}

	function manage_pictures() {

		show_loading();
		clear_user_section();

				//$("#view_user_section").hide();
				//$("#view_user_section").html(response);
				$("#view_user_section").dialog({
					open: function()
					{
						$.ajax({
							type : "POST",
							url : "index.php?route=users_content&action=manage_pictures",
							data : {

								'rh' : r_h,
								'gallery' : ''
							},
							success : function(response) {
								$("#view_user_section").html(response);
							}});
					},
					title : 'Manage your pictures',
					modal : true,
					width : '1200',
					height : '650',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});
			//	$("select").css("background",
				//		$(".ui-widget-header").css("background-color"));
				hide_loading();

			//}
		//});
	}

	function manage_music() {

		show_loading();
		clear_user_section();


				$("#view_user_section").dialog({
					open: function() {
						$.ajax({
							type : "POST",
							url : "index.php?route=users_content&action=manage_music",
							data : {

								'rh' : r_h,
								'gallery' : ''
							},
							success : function(response) {
								$("#view_user_section").html(response);
							}});
					},
					title : 'Manage your music',
					modal : true,
					width : '1200',
					height : '650',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});

				hide_loading();

			//}
		//});
	}

	function manage_videos() {

		show_loading();
		clear_user_section();


				$("#view_user_section").dialog({
					open: function()
					{
						$.ajax({
							type : "POST",
							url : "index.php?route=users_content&action=manage_videos",
							data : {

								'rh' : r_h,
								'gallery' : ''
							},
							success : function(response) {
								$("#view_user_section").html(response);
							}});
					},
					title : 'Manage your videos',
					modal : true,
					width : '1200',
					height : '650',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});
				//$("select").css("background",
					//	$(".ui-widget-header").css("background-color"));
				hide_loading();

			//}
		//});
	}

	function manage_blogs() {
		clear_user_section();


				$("#view_user_section").dialog({
					open: function() {
						$.ajax({
							type : "POST",
							url : "index.php?route=users_content&action=manage_blogs",
							data : {

								'rh' : r_h,
								'gallery' : ''
							},
							success : function(response) {
								$("#view_user_section").html(response);
							}})
					},
					title : 'Add new post',
					modal : true,
					width : '1200',
					height : '650',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});
			//	$("select").css("background",
				//		$(".ui-widget-header").css("background-color"));
				hide_loading();

			//}
		//});

	}

	function manage_events() {
		clear_user_section();


				$("#view_user_section").dialog({
					open: function() {
						$.ajax({
							type : "POST",
							url : "index.php?route=users_content&action=manage_events",
							data : {

								'rh' : r_h,
							},
							success : function(response) {
								$("#view_user_section").html(response);
							}});
					},
					title : 'Manage events',
					modal : true,
					width : '1200',
					height : '650',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});
				hide_loading();

			//}
		//});

	}

	function manage_groups() {
		clear_user_section();


				$("#view_user_section").dialog({
					open: function() {
						$.ajax({
							type : "POST",
							url : "index.php?route=users_content&action=manage_groups",
							data : {

								'rh' : r_h,
							},
							success : function(response) {
								$("#view_user_section").html(response);
							}});
					},
					title : 'Manage groups',
					modal : true,
					width : '1200',
					height : '650',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});
				//$("select").css("background",
					//	$(".ui-widget-header").css("background-color"));
				hide_loading();

			//}
		//});

	}

	function edit_profile() {
		show_loading();

		$.ajax({
			type : "POST",
			url : "index.php?route=users&action=edit_profile",
			data : {

				'rh' : r_h,
			},
			success : function(response) {
				$("#edit_profile").html('');
				$("#edit_profile").html(response);
				$("#edit_profile").dialog({
					title : 'Edit Profile',
					modal : true,
					width : '1000',
					height : '650',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					},
					close : function(event, ui) {
						$('#edit_profile_form').validationEngine('hideAll');
					}
				});

				hide_loading();

			}
		});

	}
	function show_text_page(id) {
		hide_details();
		show_loading();
		$.ajax({
			type : "GET",
			url : "index.php?route=index&action=text_page&id=" + id,
			data : {
				'rh' : r_h
			},
			success : function(response) {

				$("#middle").hide();
				$("#middle").html('');
				$("#middle").html(response);
				$("#middle").fadeIn(500);
				$("#text_page").collapse();
				hide_loading();

			}
		});

	}

	function start_webcam() {
		if ($("#webcam").length == 0) {
			show_loading();
			$.ajax({
				type : "GET",
				url : "index.php?route=users&action=start_webcam",
				data : {
					'rh' : r_h
				},
				success : function(response) {

					$("#full-page-container").prepend(response);
					hide_loading();
				}

			});
		}
	}
	function view_webcam(id, webcam_id) {
		if ($("#webcam").length == 0) {
			show_loading();
			$.ajax({
				type : "GET",
				url : "index.php?route=users&action=connect_to_webcam&id="
						+ webcam_id,
				data : {
					'rh' : r_h
				},
				success : function(response) {

					$("#full-page-container").prepend(response);
					hide_loading();
				}

			});

		}

	}

	function show_game_details(id) {

		show_loading();
		hide_details();
		$.ajax({
			type : "GET",
			url : 'index.php?route=users_content&action=view_game',
			data : {
				'id' : id,
				'rh' : r_h,
				'n_a' : 1
			},
			success : function(response) {
				$(response).prependTo($("#middle"));
					$("#details_right").collapse();
				hide_loading();
			}
		});

	}

	function show_pagination(url, div_element) {
		show_loading();
		$.ajax({
			type : "GET",
			url : 'index.php?' + url,
			data : {
				'rh' : r_h,
				'n_a' : 1
			},
			success : function(response) {
				$("#" + div_element).html('');
				// $("#"+div).hide();
				$("#" + div_element).html(response);
				bind_mouseover();
				hide_loading();
			}
		});
	}



	//Called once the server replies to the ajax form validation request

	function ajaxValidationCallback(status, form, json, options) {

		if (json.status === true) {
			if(no_ajax == 'yes')
			{
					document.location.href=site_url + 'home';
			}
			else
			{
			$("#my_account").fadeOut();
			$("#my_account").html('');
			$("#my_account").remove('');
			show_loading();
			$.ajax({
				type : "GET",
				url : "index.php?route=users&action=get_my_account",
				success : function(response) {
					$("#left_my_account").html(response);
					$("#left_my_account").fadeIn();
					$("#my_account").accordion({
						header : "h3"
					});
					 hide_loading();

				}
			});
			$.ajax({
				type : "GET",
				url : "index.php?route=users&action=welcome",
				success : function(response) {
					$("#tabs").hide();
					$("#tabs").remove();
					$("#top").html(response);
					$("#tabs").fadeIn();
				/*	$('#tabs').tabs({
						selected : 0
					});*/
					$('select#categories').selectmenu({menuWidth: 85,maxHeight:350});
					$('select#theme_selector').selectmenu({menuWidth: 85,maxHeight:350});
				}
			});

			$.ajax({
				type : "GET",
				url : "index.php?route=chat&action=get_chat",
				success : function(response) {
					$("#chat").hide();
					$("#chat").remove();
					$("#right_chat").html(response);
					$('#chat').tab('show');

				}
			});


		}
		}else {
			 show_user_notification("Invalid username or password");
			hide_loading();
		}


	}

	function beforeCall(form, options) {

		show_loading();
		return true;

	}

	$(document).ready(function() {


		jQuery("#login_form").validationEngine({

			ajaxFormValidation : true,
			onBeforeAjaxFormValidation : beforeCall,
			onAjaxFormComplete : ajaxValidationCallback,

		});

	});

	function send_general_message() {

		show_loading();
		if($.trim($("#new_general_message").val()) == '')
		{
		show_notification(empty_chat_message);
		hide_loading();
		return false;
		}
		$.ajax({
			type : 'POST',
			url : 'index.php?route=chat&action=send_generalmessage',
			data : ({
				message : $("#new_general_message").val()
			}),
			dataType : 'json',
			success : function(response) {
				$("#new_general_message").val('');
				if (response.status != '') {
					show_notification(response.status);
				} else {
					get_messages_general();

				}
				hide_loading();
			}
		});
	}
	function get_messages_general() {
		$.ajax({
			type : 'POST',
			url : 'index.php?route=chat&action=general_messages',
			data : ({

			}),

			success : function(response) {
				$("#load_general").html('');
				$("#load_general").html(response);
				//$('#chat_general').jScrollPane();
			}
		});
	}
	var auto_refresh = setInterval(function() {
		get_messages_general();
	}, 10000);

	function get_messages_friends_chat(id) {
		$.ajax({
			type : 'POST',
			url : 'index.php?route=chat&action=friend_chat_messages',
			data : ({
				id : id
			}),

			success : function(response) {
				$('#conversation_chat_friend_' + id).html();
				$('#conversation_chat_friend_' + id).html(response);
				//$('#conversation_chat_friend_' + id).jScrollPane();

			}
		});
	}
	function get_messages_friends_chat_refresh() {
		if($("#active_chat_friend").html() != '')
			{
		$.ajax({
			type : 'POST',
			url : 'index.php?route=chat&action=friend_chat_messages',
			data : ({
				id : $("#active_chat_friend").html()
			}),

			success : function(response) {
				$('#conversation_chat_friend_' + $("#active_chat_friend").html()).html();
				$('#conversation_chat_friend_' + $("#active_chat_friend").html()).html(response);
				//$('#conversation_chat_friend_' + $("#active_chat_friend").html()).jScrollPane();

			}
		});
			}
	}

	var asd = setInterval(function() {
		get_messages_friends_chat_refresh();
	}, 10000);
	function send_chat_friend_message(id) {

		show_loading();

		if($.trim($("#conversation_chat_friend_message_" + id).val()) == '')
		{
		show_notification(empty_chat_message);
		hide_loading();
		return false;
		}
		$.ajax({
			type : 'POST',
			url : 'index.php?route=chat&action=send_friendmessage',

			data : ({
				message : $("#conversation_chat_friend_message_" + id).val(),
				id : id
			}),
			//dataType : 'json',
			success : function(response) {
				$("#conversation_chat_friend_message_" + id).val('');
				//if (response.status != '') {
					//show_notification(response.status);
				//} else {
					get_messages_friends_chat(id);

				//}
				hide_loading();
			}
		});
	}

	function friend_chat(id) {
		$("#active_chat_friend").html('');
		$("#active_chat_friend").html(id);
		$("#chat_friends_default").html('');
		$("#friend_chat_input").hide();
		$(".chat_friend").hide();
		if ($("#chat_friend_" + id).length > 0) {
			$("#chat_friend_" + id).show();
		} else {
			$("#chat_friends_messages")
					.append(
							'<div id="chat_friend_'
									+ id
									+ '" class="chat_friend"><div id="conversation_chat_friend_'
									+ id
									+ '" class="chat_friend_messages"></div></div><div id="friend_chat_input"><input type="text" id="conversation_chat_friend_message_'
									+ id
									+ '" class="ui-widget-header input chat_input"><input type="button"  onclick="send_chat_friend_message(\''
									+ id + '\')" value="Send" class="ui-widget-header input "></div>');
			$("#conversation_chat_friend_message_"+id).keydown(function(event) {
			    if (event.keyCode == 13) {
			    	send_chat_friend_message(id);
			    }
			});
			get_messages_friends_chat(id);

		}
	}

	function chatroom_chat(id) {
		$("#active_chat_rooms").html(id);
		$(".chat_room").hide();
		//$("#chat_room_input").hide();
		$("#chat_rooms_default").html('');
		if ($("#chat_room_" + id).length > 0) {
			$("#chat_room_" + id).show();
		} else {
			$("#chat_rooms_messages")
					.append(
							'<div id="chat_room_'
									+ id
									+ '" class="chat_room"><div id="conversation_chat_room_'
									+ id
									+ '" class="conversation_chat_room"></div><div id="chat_room_input"><input type="text" id="conversation_chat_room_message_'
									+ id
									+ '" class="chat_input"><input type="button"  onclick="send_chat_room_message(\''
									+ id + '\')" value="Send" class="btn send_chat_room_message"></div></div>');
			$("#conversation_chat_room_message_"+id).keydown(function(event) {
			    if (event.keyCode == 13) {
			    	send_chat_room_message(id);
			    }
			});
			get_messages_room_chat(id);

		}
	}

	function get_messages_room_chat(id) {
		$.ajax({
			type : 'POST',
			url : 'index.php?route=chat&action=room_chat_messages',
			data : ({
				id : id
			}),

			success : function(response) {
				$('#conversation_chat_room_' + id).html('');
				$('#conversation_chat_room_' + id).html(response);
				//$('#conversation_chat_room_' + id).jScrollPane();

			}
		});
	}
	function get_messages_room_chat_refresh() {
		if($("#active_chat_rooms").html() != '')
			{
		$.ajax({
			type : 'POST',
			url : 'index.php?route=chat&action=room_chat_messages',
			data : ({
				id : $("#active_chat_rooms").html()
			}),

			success : function(response) {
				$('#conversation_chat_room_' + $("#active_chat_rooms").html()).html('');
				$('#conversation_chat_room_' + $("#active_chat_rooms").html()).html(response);
				//$('#conversation_chat_room_' + $("#active_chat_rooms").html()).jScrollPane();
			}
		});
			}
	}

	function send_chat_room_message(id) {

		show_loading();
		if($.trim($("#conversation_chat_room_message_" + id).val()) == '')
		{
		show_notification(empty_chat_message);
		hide_loading();
		return false;
		}
		$.ajax({
			type : 'POST',
			url : 'index.php?route=chat&action=send_roommessage',

			data : ({
				message : $("#conversation_chat_room_message_" + id).val(),
				id : id
			}),
			dataType : 'json',
			success : function(response) {
				$("#conversation_chat_room_message_" + id).val('');
				if (response.status != '') {
					show_notification(response.status);
				} else {
					get_messages_room_chat(id);

				}
				hide_loading();
			}
		});
	}

	var auto_refresh = setInterval(function() {
		get_messages_room_chat_refresh();
	}, 10000);



	function manage_extra_sections(type) {
		clear_user_section();
		$.ajax({
			type : "POST",
			url : "index.php?route=users_content&action=manage_extra_sections",
			data : {

				'rh' : r_h,
				'type' : type
			},
			success : function(response) {
				$("#view_user_section").html(response);
				$("#view_user_section").dialog({
					title : type,
					modal : true,
					width : '1200',
					height : '650',
					resizable : false,
					show : {
						effect : 'fade'
					},
					zIndex : '3000',
					hide : {
						effect : 'fade'
					}
				});
				$("select").css("background",
						$(".ui-widget-header").css("background-color"));
				hide_loading();

			}
		});

	}


	function tiny_mce()
	{
		$('textarea').tinymce({
			// Location of TinyMCE script
			script_url : site_url + 'resources/js/tiny_mce/tiny_mce.js',

			// General options
			theme : "simple",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",

			// Theme options
			theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,help,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
			theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
			theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			theme_advanced_resizing : true,

			// Example content CSS (should be your site CSS)
			//content_css : "css/content.css",

			// Drop lists for link/image/media/template dialogs
			template_external_list_url : "lists/template_list.js",
			external_link_list_url : "lists/link_list.js",
			external_image_list_url : "lists/image_list.js",
			media_external_list_url : "lists/media_list.js",

			// Replace values for the template plugin
			template_replace_values : {
				username : "Some User",
				staffid : "991234"
			}
		});

	}