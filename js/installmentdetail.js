/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

CRM.$(document).ready(function($){
  if(CRM.vars.installmentdetail.rowCount > 0) {

    // Find recurring table, if any
    var table = CRM.$('tr.crm-entity[id^=contribution_recur-]').closest('table')

    // Add column headers
    table.find('tbody tr.columnheader th:last').before('<th scope="col">' + ts('Financial Type') + '</td>');
    table.find('tbody tr.columnheader th:last').before('<th scope="col">' + ts('# Completed') + '</td>');

    table.find('tbody tr.crm-entity[id^=contribution_recur-]').each(function(idx, tr){
      var contribution_id = tr.id.split('-').pop()
      var financial_type, count;
      if (contribution_id in CRM.vars.installmentdetail.rows) {
        financial_type = CRM.vars.installmentdetail.rows[contribution_id]['financial_type']['name']
        count = CRM.vars.installmentdetail.rows[contribution_id]['count']
      } else {
        financial_type = ''
        count = 0
      }
      CRM.$(tr).find('td:last').before('<td>' + financial_type + '</td>')
      CRM.$(tr).find('td:last').before('<td>' + count + '</td>')
    });
  }


})

