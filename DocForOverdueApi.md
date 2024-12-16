1. -post-'/api/overdue/create' for admin creating a overdue request[
   'returned'=>"integer|req"
   'amount'=>"integer|req"
   'user'=>"string|req",
   "result"=>'string|req'
   "status"=>'string in OverdueStatus list|req',
   "return_date"=>'date|req',
   ]
2. -get-'/api/overdue/status-list' list of statuses
3. -get- '/api/overdue/list' list of overdue request[
   'search'=>"string|nullable"
   'filter-status'=>"string|nullable"
   'filter-amount-from'=>"integer|nullable",
   'filter-amount-to'=>"integer|nullable",
   'filter-returned-from'=>"integer|nullable",
   'filter-returned-to'=>"integer|nullable",
   ]
4. -put-'/api/overdue/update' for updating  request[
   'returned'=>"integer|req"
   'amount'=>"integer|req"
   'user'=>"string|req",
   'overdue_id''=>"overdue id from the database|req",
   "result"=>'string|req'
   "status"=>'string in OverdueStatus list|req',
   "return_date"=>'date|req',
   ]
5. -get- '/api/overdue/item/{id}'  get item
6. -delete- '/api/overdue/del/{id}'  delete item

api/reports/income-city\ 


                                             ]
