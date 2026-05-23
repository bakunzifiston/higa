# Employees module (generic CRUD) - progress

## Done
- [x] Create migration: `database/migrations/2026_05_22_000000_create_employees_table.php`
- [x] Create model: `app/Models/Employee.php`
- [x] Add `employees` to `ModuleController::edit()` allowed modules

## In Progress
- [ ] Add `employees` support in `ModuleController`:
  - [ ] `allowedModules()` includes `employees`
  - [ ] `store()` supports `employees`
  - [ ] `update()` supports `employees`
  - [ ] `destroy()` supports `employees`
  - [ ] `recordsForModule()` returns `Employee` pagination
  - [ ] `editRecord` matching for `employees` (in `edit()`)
- [ ] Add Employees UI in `resources/views/modules/index.blade.php`:
  - [ ] Form fields for employees
  - [ ] Table header/row rendering

## Notes
- If tool patching fails due to non-unique diff matches, the safest approach is to overwrite the full contents of:
  - `app/Http/Controllers/ModuleController.php`
  - `resources/views/modules/index.blade.php`

