(function ($) {
 "use strict";
 
	 // HEX
			$("#hex").spectrum({
				color: "#f00",
				preferredFormat: "hex",
				showInput: true
			});
			$("#hex2").spectrum({
				color: "#f00",
				preferredFormat: "hex2",
				showInput: true
			});
			$("#hex3").spectrum({
				color: "#f00",
				preferredFormat: "hex3",
				showInput: true
			});
			$("#hex4").spectrum({
				color: "#f00",
				preferredFormat: "hex4",
				showInput: true
			});
			$("#hex5").spectrum({
				color: "#f00",
				preferredFormat: "hex5",
				showInput: true
			});
			
			// HSL
			$("#hsl").spectrum({
				color: "#c34040",
				preferredFormat: "hsl",
				showInput: true
			});
			// RGB
			$("#rgb").spectrum({
				color: "#dbc75e",
				preferredFormat: "rgb",
				showInput: true
			});
			// Alpha RGB
			$("#a-rgb").spectrum({
				showAlpha: true,
				color: "#3dbb8f",
				preferredFormat: "rgb",
				showInput: true
			});
			// Alpha HSL
			$("#a-hsl").spectrum({
				showAlpha: true,
				color: "#8bc177",
				preferredFormat: "hsl",
				showInput: true
			});
			// Palette
			$("#palette1").spectrum({
				color: "#9257b4",
				preferredFormat: "hex",
				showInput: true,
				showPalette: true,
				palette: [
					['#000', '#fff', '#ffebcd'],
					['#ff8000', '#448026', '#ffffe0']
				]
			});
			// Palette only
			$("#palette2").spectrum({
				showPaletteOnly: true,
				showPalette:true,
				color: '#780707',
				palette: [
					['#000', '#fff', '#ffebcd','#ff8000', '#448026'],
					['#ff0000', '#fff700', '#75b274', '#1d31c3', '#9257b4']
				]
			});
			// Method "show"
			$("#hex,#hex2,#hex3,#hex4,#hex5, #hsl, #rgb, #a-hsl, #a-rgb, #palette1, #palette2").show();



	
	
 
})(jQuery); 