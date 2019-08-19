/* globals ParseUrl */
const setAudiences = function ($objects) {
  for (const anchor of $objects) {
    const $a = jQuery(anchor);
    const audienceStr = $a.data('set-audience');
    let href = $a.attr('href');
    if (href) {
      const parsed = new ParseUrl(href);
      // Audience is already set via a query param. Abort!
      if (parsed.searchObject.hasOwnProperty('audience') && parsed.searchObject.audience) {
        continue;
      }
      if (parsed.searchObject.audience !== undefined || !parsed.searchObject.hasOwnProperty('audience')) {
        parsed.searchObject.audience = audienceStr;
        href = parsed.buildUrl();
        $a.attr('href', href);
      }
    }
  }
};

(function ($) {
  const $objects = $('[data-set-audience]');

  if ($objects.length > 0) {
    setAudiences($objects);
  }
}(jQuery));
