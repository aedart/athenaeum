---
description: Events, Audit package

---

# Events

The Audit Trail package relies on events for recording changes in models. By default, each model that makes use of the `RecordsChanges` will automatically record certain types of operations, e.g. when you save your model.
However, it is unable to record all types of operations, especially if you have added custom operations inside your models.
To overcome this, you can choose to manually dispatch appropriate events, which will ensure recording.

## Record Single Change

To record a single change manually, dispatch the predefined `ModelHasChanged` event.

```php
use Aedart\Audit\Traits\RecordsChanges
use Aedart\Audit\Events\ModelHasChanged;
use Illuminate\Support\Facades\Auth;

class Category extends Model
{
    use RecordsChanges;
    
    // E.g. a custom operation in your model
    public function moveCategory()
    {
        // ... move logic not shown here...
        
        // Obtain current authenticated user (optional)
        $user = Auth::user();
        
        // Record "move" operation
        ModelHasChanged::dispatch(
            $this,
            $user,
            'category moved' // the type of change...
        );
    }
}
```

For additional information, please review source code of `Aedart\Audit\Events\ModelHasChanged`.

## Record Changes for Multiple models

To record changes for multiple models, you can dispatch the `MultipleModelsChanged` event.

```php
use Aedart\Audit\Events\MultipleModelsChanged;

// Obtain models that are about to be changed...
$categories = Category
            ->where('has_discount', true)
            ->get()

// Make and save your changes ... not shown here...

// Record changes for all changed models.
MultipleModelsChanged::dispatch($categories, Auth::user(), 'discount removed');
```

Review source code of `Aedart\Audit\Events\MultipleModelsChanged`, for additional information.
