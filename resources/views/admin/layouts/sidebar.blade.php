  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

      <ul class="sidebar-nav" id="sidebar-nav">

          <li class="nav-item">
              <a class="nav-link " href="index.html">
                  <i class="bi bi-grid"></i>
                  <span>Dashboard</span>
              </a>
          </li><!-- End Dashboard Nav -->

          {{-- sales module --}}
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.sales.customers.index') || 
              request()->routeIs('admin.sales.customers.index') || 
            request()->routeIs('admin.sales.quotation.index')
             ? '' : 'collapsed' }}" data-bs-target="#sales-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-receipt"></i><span>Sales</span><i class="bi bi-chevron-down ms-auto"></i>
              </request>
              <ul id="sales-nav" class="nav-content collapse {{ request()->routeIs('admin.sales.customers.index') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="sales-tooltips.html">
                          <i class="bi bi-circle"></i><span>Dashboard</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.sales.customers.index') }}" class="{{ request()->routeIs('admin.sales.customers.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Customers</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.sales.quotation.index') }}" class="{{ request()->routeIs('admin.sales.quotation.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Quotation</span>
                      </a>
                  </li>
              </ul>
          </li>
          {{-- end sales module --}}


          {{-- inventory module --}}
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.inventory.category.index') ||
              request()->routeIs('admin.inventory.product.index')
             ? '' : 'collapsed' }}" data-bs-target="#inventory-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-receipt"></i><span>Inventory</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="inventory-nav" class="nav-content collapse {{ request()->routeIs('admin.inventory.category.index') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('admin.inventory.category.index') }}">
                          <i class="bi bi-circle"></i><span>Category</span>
                      </a>
                  </li>
                  <li>
                    <a href="{{ route('admin.inventory.product.index') }}" class="{{ request()->routeIs('admin.inventory.product.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Products</span>
                    </a>
                </li>
              </ul>
          </li>
          {{-- end inventory module --}}


          {{-- Purchases module --}}
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.purchase.vendor.index')  
              
             ? '' : 'collapsed' }}" data-bs-target="#purchase-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-receipt"></i><span>Purchase</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="purchase-nav" class="nav-content collapse {{ request()->routeIs('admin.purchase.vendor.index') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('admin.purchase.vendor.index') }}" class="{{ request()->routeIs('admin.purchase.vendor.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Vendor</span>
                      </a>
                  </li>
                  
              </ul>
          </li>
          {{-- end Purchases module --}}


          {{-- Configuration module --}}
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.config.region.index') ? '' : 'collapsed' }}" data-bs-target="#Configuration-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-wrench"></i><span>Configuration</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="Configuration-nav" class="nav-content collapse 
            {{ request()->routeIs('admin.config.region.index') || 
            request()->routeIs('admin.config.payment_terms.index') ||
            request()->routeIs('admin.config.payment_type.index') || 
            request()->routeIs('admin.config.price_structure.index') ||
            request()->routeIs('admin.config.product_type.index') ||
            request()->routeIs('admin.config.uom.index') ||
            request()->routeIs('admin.config.tax.index') ||
            request()->routeIs('admin.config.warehouse.index')
             ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('admin.config.region.index') }}" class="{{ request()->routeIs('admin.config.region.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Region</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.config.payment_terms.index') }}" class="{{ request()->routeIs('admin.config.payment_terms.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Payment Terms</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.config.payment_type.index') }}" class="{{ request()->routeIs('admin.config.payment_type.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Payment Type</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.config.price_structure.index') }}" class="{{ request()->routeIs('admin.config.price_structure.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Price Structure</span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('admin.config.product_type.index') }}" class="{{ request()->routeIs('admin.config.product_type.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Product Type</span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('admin.config.uom.index') }}" class="{{ request()->routeIs('admin.config.uom.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Uom</span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('admin.config.tax.index') }}" class="{{ request()->routeIs('admin.config.tax.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Tax</span>
                      </a>
                  </li>


                  <li>
                    <a href="{{ route('admin.config.warehouse.index') }}" class="{{ request()->routeIs('admin.config.warehouse.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Warehouse</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.config.packing.index') }}" class="{{ request()->routeIs('admin.config.packing.index') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i><span>Packing</span>
                    </a>
                </li>
                
              </ul>
          </li>
          {{-- end Configuration module --}}

    <!-- logistic module -->
    <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.logistic.driver.index') ? '' : 'collapsed' }}" data-bs-target="#Logistic-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-wrench"></i><span>Logistic</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="Logistic-nav" class="nav-content collapse 
            {{ request()->routeIs('admin.logistic.driver.index') || 
            request()->routeIs('admin.fleet.service.index') ||
            request()->routeIs('admin.fleet.fleettracking.index')
             ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('admin.logistic.driver.index') }}" class="{{ request()->routeIs('admin.logistic.driver.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Driver Management</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.fleet.vehicle.index') }}" class="{{ request()->routeIs('admin.fleet.vehicle.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Order</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.fleet.service.index') }}" class="{{ request()->routeIs('admin.fleet.service.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Order Tracking</span>
                      </a>
                  </li>
              </ul>
          </li>
          <!-- end logistic module -->

          <!-- fleet module -->
          <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('admin.fleet.vehicle.index') ? '' : 'collapsed' }}" data-bs-target="#Fleet-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-wrench"></i><span>Fleet</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="Fleet-nav" class="nav-content collapse 
            {{ request()->routeIs('admin.fleet.expired_documents') || 
            request()->routeIs('admin.fleet.service.index') ||
            request()->routeIs('admin.fleet.vehicle.index') || 
            request()->routeIs('admin.fleet.dailylog.index') ||
            request()->routeIs('admin.fleet.fleettracking.index')
             ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="{{ route('admin.fleet.expired_documents') }}" class="{{ request()->routeIs('admin.fleet.expired_documents') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Dashboard</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.fleet.vehicle.index') }}" class="{{ request()->routeIs('admin.fleet.vehicle.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Vehicle</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.fleet.service.index') }}" class="{{ request()->routeIs('admin.fleet.service.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Services</span>
                      </a>
                  </li>
                  <li>
                      <a href="{{ route('admin.fleet.dailylog.index') }}" class="{{ request()->routeIs('admin.fleet.dailylog.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Daily Log</span>
                      </a>
                  </li>

                  <li>
                      <a href="{{ route('admin.fleet.fleettracking.index') }}" class="{{ request()->routeIs('admin.fleet.fleettracking.index') ? 'active' : '' }}">
                          <i class="bi bi-circle"></i><span>Fleet Tracking</span>
                      </a>
                  </li>
              </ul>
          </li>
          <!-- end fleet module -->

          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="components-alerts.html">
                          <i class="bi bi-circle"></i><span>Alerts</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-accordion.html">
                          <i class="bi bi-circle"></i><span>Accordion</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-badges.html">
                          <i class="bi bi-circle"></i><span>Badges</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-breadcrumbs.html">
                          <i class="bi bi-circle"></i><span>Breadcrumbs</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-buttons.html">
                          <i class="bi bi-circle"></i><span>Buttons</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-cards.html">
                          <i class="bi bi-circle"></i><span>Cards</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-carousel.html">
                          <i class="bi bi-circle"></i><span>Carousel</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-list-group.html">
                          <i class="bi bi-circle"></i><span>List group</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-modal.html">
                          <i class="bi bi-circle"></i><span>Modal</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-tabs.html">
                          <i class="bi bi-circle"></i><span>Tabs</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-pagination.html">
                          <i class="bi bi-circle"></i><span>Pagination</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-progress.html">
                          <i class="bi bi-circle"></i><span>Progress</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-spinners.html">
                          <i class="bi bi-circle"></i><span>Spinners</span>
                      </a>
                  </li>
                  <li>
                      <a href="components-tooltips.html">
                          <i class="bi bi-circle"></i><span>Tooltips</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End Components Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#forms-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-journal-text"></i><span>Forms</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="forms-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="forms-elements.html">
                          <i class="bi bi-circle"></i><span>Form Elements</span>
                      </a>
                  </li>
                  <li>
                      <a href="forms-layouts.html">
                          <i class="bi bi-circle"></i><span>Form Layouts</span>
                      </a>
                  </li>
                  <li>
                      <a href="forms-editors.html">
                          <i class="bi bi-circle"></i><span>Form Editors</span>
                      </a>
                  </li>
                  <li>
                      <a href="forms-validation.html">
                          <i class="bi bi-circle"></i><span>Form Validation</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End Forms Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#tables-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-layout-text-window-reverse"></i><span>Tables</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="tables-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="tables-general.html">
                          <i class="bi bi-circle"></i><span>General Tables</span>
                      </a>
                  </li>
                  <li>
                      <a href="tables-data.html">
                          <i class="bi bi-circle"></i><span>Data Tables</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End Tables Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#charts-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-bar-chart"></i><span>Charts</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="charts-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="charts-chartjs.html">
                          <i class="bi bi-circle"></i><span>Chart.js</span>
                      </a>
                  </li>
                  <li>
                      <a href="charts-apexcharts.html">
                          <i class="bi bi-circle"></i><span>ApexCharts</span>
                      </a>
                  </li>
                  <li>
                      <a href="charts-echarts.html">
                          <i class="bi bi-circle"></i><span>ECharts</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End Charts Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" data-bs-target="#icons-nav" data-bs-toggle="collapse" href="#">
                  <i class="bi bi-gem"></i><span>Icons</span><i class="bi bi-chevron-down ms-auto"></i>
              </a>
              <ul id="icons-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
                  <li>
                      <a href="icons-bootstrap.html">
                          <i class="bi bi-circle"></i><span>Bootstrap Icons</span>
                      </a>
                  </li>
                  <li>
                      <a href="icons-remix.html">
                          <i class="bi bi-circle"></i><span>Remix Icons</span>
                      </a>
                  </li>
                  <li>
                      <a href="icons-boxicons.html">
                          <i class="bi bi-circle"></i><span>Boxicons</span>
                      </a>
                  </li>
              </ul>
          </li><!-- End Icons Nav -->

          <li class="nav-heading">Pages</li>

          <li class="nav-item">
              <a class="nav-link collapsed" href="users-profile.html">
                  <i class="bi bi-person"></i>
                  <span>Profile</span>
              </a>
          </li><!-- End Profile Page Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" href="pages-faq.html">
                  <i class="bi bi-question-circle"></i>
                  <span>F.A.Q</span>
              </a>
          </li><!-- End F.A.Q Page Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" href="pages-contact.html">
                  <i class="bi bi-envelope"></i>
                  <span>Contact</span>
              </a>
          </li><!-- End Contact Page Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" href="pages-register.html">
                  <i class="bi bi-card-list"></i>
                  <span>Register</span>
              </a>
          </li><!-- End Register Page Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" href="pages-login.html">
                  <i class="bi bi-box-arrow-in-right"></i>
                  <span>Login</span>
              </a>
          </li><!-- End Login Page Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" href="pages-error-404.html">
                  <i class="bi bi-dash-circle"></i>
                  <span>Error 404</span>
              </a>
          </li><!-- End Error 404 Page Nav -->

          <li class="nav-item">
              <a class="nav-link collapsed" href="pages-blank.html">
                  <i class="bi bi-file-earmark"></i>
                  <span>Blank</span>
              </a>
          </li><!-- End Blank Page Nav -->

      </ul>

  </aside><!-- End Sidebar-->