/* eslint-disable no-unused-vars */
class ParseUrl {
  constructor(url) {
    this.url = url;
    this.parse();
  }

  parse() {
    const parser = document.createElement('a');
    const searchObject = {};

    let queries = [];
    let split;
    let i;

    parser.href = this.url;

    queries = parser.search.replace(/^\?/, '').split('&');
    for (i = 0; i < queries.length; i++) {
      split = queries[i].split('=');
      if (split[0] !== '' && split[0] !== null) {
        searchObject[split[0]] = split[1];
      } else if (split[1] === null) {
        searchObject[split[0]] = true;
      }
    }

    this.protocol = parser.protocol;
    this.host = parser.host;
    this.hostname = parser.hostname;
    this.port = parser.port;
    this.pathname = parser.pathname;
    this.search = parser.search;
    this.searchObject = searchObject;
    this.hash = parser.hash;
  }

  queryString() {
    return Object.keys(this.searchObject)
      .map((k) => `${escape(k)}=${escape(this.searchObject[k])}`)
      .join('&');
  }

  buildUrl() {
    const queryString = this.queryString();
    const url = `${this.protocol}//${this.host}${this.pathname}?${queryString}`;
    return url;
  }
}
/* eslint-enable no-unsued-vars */
