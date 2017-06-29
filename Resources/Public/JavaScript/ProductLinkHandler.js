define(['jquery', 'TYPO3/CMS/Recordlist/LinkBrowser'], function ($, LinkBrowser) {
	'use strict';

	var ProductLinkHandler = {};

	ProductLinkHandler.createMyLink = function (event) {
		var val = $(this).data('productId');

		// optional: If your link points to some external resource you should set this attribute
		LinkBrowser.setAdditionalLinkAttribute('data-htmlarea-external', '1');

		LinkBrowser.finalizeFunction('t3://shopware-product?id=' + val);
	};

	ProductLinkHandler.initialize = function () {
		// todo add necessary event handlers, which will propably call ProductLinkHandler.createMyLink
	};

	$(ProductLinkHandler.initialize);

	$(function() {
		ProductLinkHandler.currentLink = $('body').data('currentLink');

		$('a.t3js-productLink').on('click', ProductLinkHandler.createMyLink);
	});

	return ProductLinkHandler;
});
