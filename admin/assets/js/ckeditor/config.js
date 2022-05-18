/**
 * @license Copyright (c) 2003-2022, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	filebrowserBrowseUrl= '/apps/ckfinder/3.4.5/ckfinder.html',
      filebrowserImageBrowseUrl= '/apps/ckfinder/3.4.5/ckfinder.html?type=Images',
      filebrowserUploadUrl= '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Files',
      filebrowserImageUploadUrl= '/apps/ckfinder/3.4.5/core/connector/php/connector.php?command=QuickUpload&type=Images',
      removeButtons= 'PasteFromWord'
};
