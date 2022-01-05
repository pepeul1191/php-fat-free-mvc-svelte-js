export const CSRF = {
  key: document.querySelector('meta[name=csrf]').getAttribute('key'),
  value: document.querySelector('meta[name=csrf]').getAttribute('value')
};