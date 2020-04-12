# JS-TREE and Doctrine Tree Extension

Install SurvosLanding

## Install Doctrine Tree Extension

```bash
composer req antishov/doctrine-extensions-bundle
```

Modify the configuration
```yaml
# stof_doctrine_extensions.yaml
stof_doctrine_extensions:
    default_locale: en_US
    orm:
        default:
            sluggable: true
            tree: true

```

## Create the entity

```bash
bin/console make:entity Location
    code, string, 32
    name, string, 80
```

Add the tree properties.  Change 'Location' to your class name if necessary.
Two parts, the header, set the slugger on 'code', and then add the properties.

```php
use Gedmo\Mapping\Annotation as Gedmo; // <-- Add this

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 * @Gedmo\Tree(type="nested") <-- Add This
 */
...
    /**
     * @ORM\Column(type="string", length=32)
     * @Gedmo\Slug(fields={"name"}) <-- add this
     */
    private $code;

```   

```php
    /**
     * @Gedmo\TreeLeft
     * @ORM\Column(type="integer")
     */
    private $lft;

    /**
     * @Gedmo\TreeLevel
     * @ORM\Column(type="integer")
     */
    private $lvl;

    /**
     * @Gedmo\TreeRight
     * @ORM\Column(type="integer")
     */
    private $rgt;

    /**
     * @Gedmo\TreeRoot
     * @ORM\ManyToOne(targetEntity="Location")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $root;

    /**
     * @Gedmo\TreeParent
     * @ORM\ManyToOne(targetEntity="Location", inversedBy="children")
     * @ORM\JoinColumn(referencedColumnName="id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="Location", mappedBy="parent")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    private $children;

```

Now generate the setters and getters.

```bash
bin/console make:entity App\\Entity\\Location --regenerate
```

Set the LocationRepository.php repository to extend the NestTreeRepsitory.  Alas, you must remove the constructor
```php
class LocationRepository extends NestedTreeRepository // was ServiceEntityRepository
{

```

Create a fixtures file to get start

```bash
composer require orm-fixtures --dev 
bin/console make:fixture
```

bin/console doctrine:schema:update --force
bin/console doctrine:fixtures:load -n



