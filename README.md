# Nette-framework SEO extension

Nette-framework SEO extension is a simple module to build head meta tags for website in simple steps.

## Installation

```shell
composer require milankyncl/nette-seo
```

## Usage

1. Register extension in your ```config.neon``` file.

    ```neon
    extensions:
        # ...
        seo: MilanKyncl\Nette\SEO\DI\SEOExtension
    ```

2. Set your preferences.

    ```neon
    
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
    
4. Create meta tags component

    ```php
     
    public function createComponentSeoMetaTags() {
       
       // You can use some methods from documentation here
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
               {control seoMetaTags} {* Will genereate all custom meta tags, then title, and finally seo tags *}
               <link rel="stylesheet" href="style.css">   
           </head>
           <body>
        
           </body>
       </html>
    ```