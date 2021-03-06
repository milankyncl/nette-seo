# Nette-framework SEO extension

Nette-framework SEO extension is a simple module to build head meta tags for website in simple steps.

## Installation

```shell
composer require milankyncl/nette-seo
```

## Usage

1. Register extension in your ```config.neon``` file.

    ```yaml
    extensions:
        # ...
        seo: MilanKyncl\Nette\SEO\DI\SEOExtension
    ```

2. Set your preferences.

    ```yaml
    
    seo:
        site_name: "Super cool website!" # Your website Name
        description: "Description for your website" # Website default description
        image: 
            url: "//www.example.cz/super-cool-image.png" # Preview image URL
            width: 1260 # Image width
            height: 630 # Image height
        # Or just:
        # image: "//www.example.cz/super-cool-image.png"
        separator: '-' # Title separator 
        customTags: # Your custom tags, will show before title tag
            copyright: 'Company 2018' # Copyright eg.
            author: 'Name <email@email.com>' # Author eg.
    ```
    
3. Inject SEOResolver factory and MetaTags component in your BasePresenter.

    ```php
    
    // With @inject annotation:
     
    /** @var \MilanKyncl\Nette\SEO\SEOResolver @inject */
    public $seo;
     
    /** @var \MilanKyncl\Nette\SEO\Components\MetaTags @inject */
    public $metaTagsComponent;
     
    // Or in constructor:
     
    public function __construct(\MilanKyncl\Nette\SEO\SEOResolver $seo, \MilanKyncl\Nette\SEO\Components\MetaTags $metaTagsComponent) {
     
       $this->seo = $seo;
       $this->metaTagsComponent = $metaTagsComponent;
     
    }
 
    ```
    
4. Create Seo Meta tags component (in BasePresenter) and in your action set title, description, or custom meta tags for your head. Use methods from [documentation](#documentation)

    ```php
 
    // HomepagePresenter eg.
     
    public function indexAction() {
       
       $this->seo->setTitle('Homepage'); // The title will look like: Homepage - Super cool website! ({$title} {$separator} {$site_name})
 
    }
     
    // Base Presenter
     
    public function createComponentSeoMetaTags() {
       
       // You can use some methods to change default options from documentation here
       // before returning the component
       // $this->seo–>setTitle($title)
       // $this->seo–>setDescription($description)
       // $this->seo–>setImage($url, $width, $height)
        
       // Use this right before returning the component
       $this->metaTagsComponent->setResolver($this->seo);
     
       return $this->metaTagsComponent;   
     
    }
 
    ```
    
5. Place control macro in your .latte file.
    
    ```latte
       
       <html>
           <head>
               {* 
                * Will genereate all custom meta tags, 
                * then title and finally seo tags 
                *}
               {control seoMetaTags}
            
               {* Your head content *}
               <link rel="stylesheet" href="style.css">   
           </head>
           <body>
        
           </body>
       </html>
    ```
    
## Documentation

### Configuration

**site_name**

Name of your site, will be showed in `<title>` tag after/before page title and separator. Will set `og:title`, `twitter:title`, `og:site_name` meta properies.
```
default: null
options: string
```

**description**

Description of your page, will set in `description`, `og:description`, `twitter:description` meta properties.
```
default: null
options: string
```

**type**

Type of your object/content. More info about the property at [ogp.me#types](http://ogp.me/#types).
```
default: 'website'
options: string
```

**image**

Preview image of your website. Will set `og:image`, `twitter:image`. You can specify only Url of image, or specify `url`, `width` and `height` parameters.
```
default: null
options: string|object
```

**separator**

Separator in your `<title>` element.
```
default: '-'
options: string
```

**customTags**

Custom meta tags. Key of array item will appear `name` attribute and its value will appear in `content` attribute. 
```
default: []
options: Array
```

