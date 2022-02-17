const modules = Array.from(document.querySelectorAll('[data-module]'));

modules.forEach((module) => {
  const componentName = module.getAttribute('data-module');
    var jsmodule = require(`./components/${componentName}.js`);
    jsmodule.default.init(module)
});