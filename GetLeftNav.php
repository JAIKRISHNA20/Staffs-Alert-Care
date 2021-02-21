<?php
class Admin_View_Helper_GetLeftNav extends Zend_View_Helper_Abstract
{
	public function getLeftNav(){
		?>
           <div id="sidebar">
  				<ul>
                	<li><h3><a href="/admin/index" class="house">Dashboard</a></h3></li>
					<li><h3><a href="/admin/policies" class="folder_table">Policies</a></h3>
          				<ul>
							<li><a href="/admin/policies/add" class="addorder">Add Policy</a></li>
                        </ul>
                    </li>
	                  <li><h3><a href="/admin/users" class="user">Users</a></h3>
          				<ul>
                            <li><a href="/admin/users/add" class="useradd">Add user</a></li>
                         	<li><a href="/admin/template/">Mass Mail</a></li>
                        </ul>
                    </li>
                    <li><h3><a href="/admin/orders" class="folder_table">Orders</a></h3>
          				<ul>
                        	<li><a href="/admin/orders/" class="search">Search</a></li>
                       </ul>
	                 </li>
                    <li><h3><a href="/admin/iprules/" class="folder_table">Ban/Unban Ipaddress</a></h3>
          				<ul>
                        	<li><a href="/admin/iprules/blockipaddress" class="search">Block Ipaddress</a></li>
                       </ul>
	                 </li>
	                 <li><h3><a href="/admin/reports/" class="folder_table">Reports</a></h3>
          				<ul>
                    		<li><a href="/admin/reports/" class="report_seo">Mail Sent Report</a></li>
	                   		<li><a href="/admin/reports/undelivered" class="report_seo">Undelivered Mail Report</a></li>
	                   		<li><a href="/admin/reports/iptablebanlist" class="report_seo">Banned IP Addresses</a></li>
	                   		<li><a href="/admin/tracking/" class="report_seo">Tracking Hackers</a></li>
                       </ul>
                    </li>
				</ul>       
          </div>
<?
	}
}