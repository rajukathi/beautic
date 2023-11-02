<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @vite('resources/js/app.js')
         <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
        <style>
            /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
            .row.content {height: 1500px}
            
            /* Set gray background color and 100% height */
            .sidenav {
              background-color: #f1f1f1;
              height: 100%;
            }
            .nav {
                display: inline;
            }
            
            /* Set black background color, white text and some padding */
            footer {
              background-color: #555;
              color: white;
              padding: 15px;
            }
            
            /* On small screens, set height to 'auto' for sidenav and grid */
            @media screen and (max-width: 767px) {
              .sidenav {
                height: auto;
                padding: 15px;
              }
              .row.content {height: auto;} 
            }
            .content-header {
                height: 48px;
                padding-top: 10px;
                background-color: gray;
            }
          </style>
        
    </head>
    <body>
        <div class="container-fluid" style="font-size: initial;">
            <div class="row content" id="app">
                <div class="col-sm-3 sidenav">
                    <h2 style="font-size: 4rem;text-align: center;background-color: black;color: wheat;">Beautic shop</h2>
                    <ul class="nav nav-pills nav-stacked" style="display: inline;">
                        <li class="active">
                            <router-link to="/">home</router-link>
                        </li>
                        <li>
                            <router-link to="/category">Category</router-link>
                        </li>
                        <li>
                            <router-link to="/tags">Tags</router-link>
                        </li>
                        <li>
                            <router-link to="/products">Products</router-link>
                        </li>
                    </ul>
                    
                </div>
                <div class="col-sm-9"  >
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </body>
</html>
