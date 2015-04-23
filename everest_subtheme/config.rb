# https://github.com/Compass/compass/tree/master/import-once
require 'compass/import-once/activate'

# http://compass-style.org/help/documentation/configuration-reference/
http_path = "/"
css_dir = (environment == :production) ? "assets/dist/css" : "assets/dev/css"
sass_dir = "assets/src/scss"
images_dir = "images"
images_path = "assets/src/images"
generated_images_dir = (environment == :production) ? "assets/dist/images" : "assets/dev/images"
javascripts_dir = (environment == :production) ? "assets/dist/js" : "assets/dev/js"
fonts_dir = "fonts"
fonts_path = "assets/src/fonts"

# The output style for the compiled css.
# One of: :nested, :expanded, :compact, or :compressed.
output_style = (environment == :production) ? :compressed : :expanded

# Indicates whether the compass helper functions should generate 
# relative urls from the generated css to assets, or absolute urls 
# using the http path for that asset type.
relative_assets = true

# Indicates whether line comments should be added to compiled css 
# that says where the selectors were defined. Defaults to false 
# in production mode, true in development mode.
line_comments = (environment == :production) ? false : true
