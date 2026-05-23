# Employees module patch plan

## Goal
Make the `employees` module fully functional in the existing dynamic modules CRUD UI.

## Files to fully overwrite (safe approach)
1) `app/Http/Controllers/ModuleController.php`
   - Add `employees` to `allowedModules()` (for admin at least)
   - Add `employees` to `store()`, `update()`, `destroy()` match branches
   - Add `employees` to `recordsForModule()` match branch returning `Employee::query()->latest()->paginate(...)`
   - Add `employees` editRecord match branch in `edit()`

2) `resources/views/modules/index.blade.php`
   - Add `@elseif($module === 'employees')` to modal form for all fields from `Employee::$fillable`
   - Add `@elseif($module === 'employees')` to table header + row rendering

## Notes
- I will avoid fragile `edit_file` diff patches and overwrite full file contents to ensure the `employees` blocks land correctly.

