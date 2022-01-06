export const CSRF = 
{
  key: (document.querySelector('meta[name=csrf]') != null) ? document.querySelector('meta[name=csrf]').
  attributes.getAttribute('key') : 'key',
  key: (document.querySelector('meta[name=csrf]') != null) ? document.querySelector('meta[name=csrf]').attributes.getAttribute('value') : 'value',
};