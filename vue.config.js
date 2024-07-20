chainWebpack: config => {
  config.plugin('html').tap(args => {
    args[0].title = "Mekinawipa - Mepa";
    return args;
  });

  // Generate a new timestamp for each build
  const timestamp = Date.now();

  // Update the asset filenames to include the timestamp
  config.output.filename(`js/[name].[contenthash:8].${timestamp}.js`);
  config.output.chunkFilename(`js/[name].[contenthash:8].${timestamp}.js`);
  config.plugin('mini-css-extract')
    .tap(([options]) => [{
      ...options,
      filename: `css/[name].[contenthash:8].${timestamp}.css`
    }]);

  // Add the version variable to the webpack DefinePlugin
  config.plugin('define').tap((args) => {
    args[0]['process.env']['APP_VERSION'] = `"${timestamp}"`;
    return args;
  });

  // Remove PWA and workbox plugins if not needed
  config.plugins.delete('pwa');
  config.plugins.delete('workbox');

  config.resolve.alias.set('@vue/runtime-dom', '@vue/runtime-dom/dist/runtime-dom.esm-bundler.js');
}
