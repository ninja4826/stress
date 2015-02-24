# Workorder migration tables

## TABLES

### Staff
1. addresses
2. staff

### Workorders
1. wo_types
2. wo_statuses
3. requestors
4. workorders
5. wo_update_histories

### Tasks
1. task_statuses
2. task_types
3. tasks
4. wo_task
5. wo_task_update_histories
6. part_task

## TODO

### Staff
- Controllers
  - [ ] staff
    - [ ] add creation of address
- Models
  - [ ] staff
  - [ ] addresses
- Templates
  - [ ] staff
    - [ ] add
      - [ ] add creation of address
    - [ ] view
      - [ ] show address
      - [ ] correct layout
    - [ ] index
      - [ ] correct table layout
      
### Workorders & Tasks
- [ ] Create plugin
- [ ] Move migrations
  - [x] Create new migration based off of old
  - [x] Delete old migrations