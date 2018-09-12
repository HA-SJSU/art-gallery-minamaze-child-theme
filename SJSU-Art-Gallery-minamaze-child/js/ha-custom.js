//Replacing poster with thumbnail
var HaCustom = (function($, window, Clipboard) {

	window.onload = function() {
		new Clipboard('.clipboard');		//init the clipboard element with class clipboard
											//USAGE: https://clipboardjs.com/
											//USAGE: add "clipboard" class to any element you want to add clipboard capability to
	};

	/**
	  * Get thumb url based on the event url
	  * This function assumes that the pictures follow the following convention:
	  * {Poster Name}_large.{Extension}
	  * {Poster Name}_thumb.{Extension} 
	  *	
	  * @param {String} eventImageUrl - the featured image url
	  * @return {String} event image url
	  */
	getThumbUrl = function(eventImageUrl) {
		if(eventImageUrl.match(/_large/)) {		//image has keyword "_large"
			var urlArr = eventImageUrl.split("_large"); //split the strings`
			urlArr.splice(-1,0,"_thumb");				//insert _thumb and replace _large
			var thumbURL = urlArr.join('');				//get the thumb url eventImageUrl,
			return thumbURL;
		} 
		return eventImageUrl;
	}


	var public = {};
	/**
	  * DEPRECATED - please use EMHaCustom object
 	  * Generate html for ticket button 
	  * @param {Object} options - {
	  * 		attr_name: "Ovationtix Link",
	  * 		ticketLink: {String}
	  *		btnImgLink: {String}
	  * @return {HTML|false}	  
	*/
	public.generateTicketBtn = function(options) {
		console.log("NOTICE: This function is deprecated! Please use EMHaCustom Object.");
		if(options.attr_name === 'Ovationtix Link') {
			if(!options.ticketLink || !options.btnImgLink) {
				console.log("ERROR: Undefined ticketLink or btnImgLink");
				return false;
			}	
			var template =  '<a href=\'' + options.ticketLink + '\'>' +
				'<img src=\'' + options.btnImgLink + '\' alt="Buy Ticket"></img>' +
				'</a>';
				
			return $.parseHTML(template)[0];			
		} else {
			//console.log('ERROR: Unknown attribute name', options.attr_name);
			return false;
		}
	}	

	/**
	  * Create a ticket button and attach it to the sibling element
	  * @param {String} ticketLink - ticket link
	  * @param {String} siblingEle - sibling javavscript object
	  */
	public.displayTicketBtn = function(ticketLink,siblingEleId) {
		console.log("display ticket btn", ticketLink);
		ticketLink = ticketLink || 'None';
		//TODO -test this 
		if( ticketLink !== 'None' ) { //has ticket link 
			var ticketBtn = document.createElement('button');
			ticketBtn.innerHTML = ' Buy Tickets ';
			ticketBtn.style.marginBottom = "20px";
			ticketBtn.onclick = function() {
				window.location.href = ticketLink;
			}
			$(ticketBtn).insertAfter("#"+siblingEleId);

			return ticketBtn;
		}
	}

		
	/**
	  * Display the thumbnail of an event which is derived from the name of the featured image. 
	  * Note: This function is intended to be used in the event list view 
	  *
	  * @param {String} eventImageUrl - the featured image url
	  * @param {String} eventName - event name
	  * @param {String} eventId - event id
	  */
	public.displayThumb = function(eventImageUrl,eventName,eventId,parent) {
		var acceptableExt = ['png','jpgs','jpeg'];
		var thumbURL = getThumbUrl(eventImageUrl);
		var thumb = document.createElement('img');

		thumb.setAttribute("alt", eventName + " Thumbnail");			//set alt text
		thumb.setAttribute("exts", acceptableExt.join(",") );
		thumb.addEventListener('load',function(){ 						//attach thumbnail image
			parent.appendChild(this);
		});
		thumb.addEventListener('error',function(e){
			e.stopPropagation();
			e.preventDefault();
			let currentSrc = e.target.src;
			let currentSrcExt = currentSrc.substring(currentSrc.lastIndexOf('.')+1);
			let exts = thumb.getAttribute('exts').split(',');
			//remove current extension from exts list
			exts = $.grep(exts, function(ele, i) {
				return ele !== currentSrcExt;
			}); 

			//select a new extenstion
			if(exts.length > 0) {
				var newExt = exts[0];
				thumb.setAttribute("exts", exts.join(",") );
				let newUrl = thumbURL.replace(new RegExp(currentSrcExt + '$'), newExt);
				thumb.src = newUrl;
				console.log(thumb,currentSrc, currentSrcExt, exts, newExt, newUrl);
			}
		},true);

		thumb.src = thumbURL;											//trigger the image load
	}

	return public;
})(jQuery, window, Clipboard);
