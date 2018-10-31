// Variable to track the pages.
var currentPage = 1;
// Initial first page images load.
selectedImages();

/**
 * selectedImages(paginate) returns a gallery of images
 * based on the passed-in pagination click.
 */
function selectedImages(paginate = 0) {

    var selectedImages = [];
    var pageLimit = 9;
    var total_pages = Math.ceil(galleryArray.length/pageLimit);

    // Moves the Current Page as per RIGHT or LEFT clicks. Default: 1
    currentPage = (currentPage + paginate) <= 0 ? 1 : (currentPage + paginate);
    // If the Current Page is more than the total pages, then limit to Total Pages size.
    currentPage = (currentPage > total_pages) ? total_pages : currentPage;

    // Start and End indexes for the array slice for the images per page.
    var start = (currentPage - 1) * pageLimit;
    var end = currentPage * pageLimit;

    selectedImages = galleryArray.slice(start, end);
    return displayImages(selectedImages);
}

/**
 * displayImages(selectedImages) prints a gallery of images
 * on the gallery div based on the passed-in selected images
 */
function displayImages(selectedImages) {
	var gallery = document.getElementsByClassName("gallery")[0];
	if(gallery !== undefined) gallery.innerHTML = selectedImages.join("");
    document.getElementById('logo').scrollIntoView({ behavior: 'smooth' });
}