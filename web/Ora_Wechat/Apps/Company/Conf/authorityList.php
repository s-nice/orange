<?php
return array(
        'AuthorityList'=>array(/* 
                //例子 财务  模块名
                'finance'=>array(
                        'name'=>'finance', //同数组的键名相同
                        'text' => "str_menu_financial_manage",//财务翻译
                        'children' => array(//财务模块里面包含的各个子模块
                                //发票资质
                                'invoice_qualified'=>array(
                                        'name'=>'invoice_qualified',   //同数组键名相同
                                        'text'=>'str_invoice_qualified',//翻译    发票资质
                                        //每个子功能对应N个controller和action
                                        'children'=>array(
                                            //发票资质修改
                                            'invoice_qualified_edit'=>array(
                                                    'name'=>'invoice_qualified_edit',
                                                    'text'=>'str_invoice_qualified_edit',
                                                    'access'=>array(
                                                        array('ctr'=>'Finance','act'=>'index,invoiceMsg,msgPost'),
                                                    ),
                                            )),
                                        ),
                                        
                                //申请发票
                                'apply_invoice'=>array(
                                        'name'=>'apply_invoice',  //同数组键名相同
                                        'text'=>'str_apply_invoice',//申请发票翻译
                                        'children'=>array(
                                            //申请发票
                                            'apply_invoice'=>array(
                                                'name'=>'apply_invoice',
                                                'text'=>'str_apply_invoice',
                                                'access'=>array(
                                                        array('ctr'=>'Finance','act'=>'invoiceList,apply,applyPost'),
                                                )),

                                                ),
                                            ),

                        )
                ),
                'staff'=>array(
                    'name'=>'staff',
                    'text'=>'str_menu_employees_manage',
                    'children'=>array(
                        //员工邀请
                        'staff_index'=>array(
                            'name'=>'staff_index',
                            'text'=>'str_menu_employees_invite',
                            'children'=>array(
                                //员工列表
                                'employee_list'=>array(
                                    'name'=>'employee_list',
                                    'text'=>'str_employee_list',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'index'),
                                    ),
                                ),
                                //新增员工
                                'employee_add'=>array(
                                    'name'=>'employee_add',
                                    'text'=>'str_employee_add',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'addStaff'),
                                    ),
                                ),
                                //编辑员工
                                'employee_edit'=>array(
                                    'name'=>'employee_edit',
                                    'text'=>'str_employee_edit',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'editStaff'),
                                    ),
                                ),
                                //删除员工
                                'employee_del'=>array(
                                    'name'=>'employee_del',
                                    'text'=>'str_employee_del',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'delStaff'),
                                    ),
                                ),
                                //批量导入
                                'employee_import'=>array(
                                    'name'=>'employee_import',
                                    'text'=>'str_employee_import',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'importStaff,downloadFile'),
                                    ),
                                ),
                            ),
                            
                        ),
                        //客户共享
                        'customershare'=>array(
                            'name'=>'customershare',
                            'text'=>'str_menu_employees_customer_share',
                            'children'=>array(
                                //共享列表
                                'customershare_list'=>array(
                                    'name'=>'customershare_list',
                                    'text'=>'str_customershare_list',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'customerShare'),
                                    ),
                                ),
                                //新建共享
                                'customershare_add'=>array(
                                    'name'=>'customershare_add',
                                    'text'=>'str_customershare_add',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'customRules,saveCustomRules'),
                                    ),
                                ),
                                //编辑共享
                                'customershare_edit'=>array(
                                    'name'=>'customershare_edit',
                                    'text'=>'str_customershare_edit',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'customRules,saveCustomRules'),
                                    ),
                                ),
                                //删除共享
                                'customershare_del'=>array(
                                    'name'=>'customershare_del',
                                    'text'=>'str_customershare_del',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'deleteCustomRules'),
                                    ),
                                ),
                            ),
                            
                        ),
                        //消费规则
                        'consumerules'=>array(
                            'name'=>'consumerules',
                            'text'=>'str_menu_employees_consumption_rules',
                            'children'=>array(
                                //消费规则列表列表
                                'consumerules_list'=>array(
                                    'name'=>'consumerules_list',
                                    'text'=>'str_consumerules_list',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'consumeRules'),
                                    ),
                                ),
                                //消费规则新增
                                'consumerules_add'=>array(
                                    'name'=>'consumerules_add',
                                    'text'=>'str_consumerules_add',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'newConsumeRules,saveConsumeRules'),
                                    ),
                                ),
                                //消费规则编辑
                                'consumerules_edit'=>array(
                                    'name'=>'consumerules_edit',
                                    'text'=>'str_consumerules_edit',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'newConsumeRules,saveConsumeRules'),
                                    ),
                                ),
                                //消费规则删除
                                'consumerules_del'=>array(
                                    'name'=>'consumerules_del',
                                    'text'=>'str_consumerules_del',
                                    'access'=>array(
                                        array('ctr'=>'Staff','act'=>'delConsumeRules'),
                                    ),
                                ),
                            ),
                            
                        ),
                    ),
                ),

                //客户
                'customer'=>array(
                    'name'=>'customer',
                    'text'=>'str_customer_manage',
                    'children'=>array(
                        //客户名片
                        'customer_card'=>array(
                            'name'=>'customer_card',
                            'text'=>'str_menu_customer_card',
                            'children'=>array(
                                //名片列表
                                'cards_list'=>array(
                                    'name'=>'cards_list',
                                    'text'=>'str_customer_cards_list',
                                    'access'=>array(
                                        array('ctr'=>'Customer','act'=>'index,showCardList'),
                                    ),
                                ),
                                //导出名片
                                'cards_export'=>array(
                                    'name'=>'cards_export',
                                    'text'=>'str_customer_cards_export',
                                    'access'=>array(
                                        array('ctr'=>'Export','act'=>'exportInfo'),
                                    ),
                                ),
                                //导入名片
                                'cards_import'=>array(
                                    'name'=>'cards_import',
                                    'text'=>'str_customer_cards_import',
                                    'access'=>array(
                                        array('ctr'=>'Customer','act'=>'importCustomer'),
                                    ),
                                ),
                            ),
                            
                        ),
                        //客户公司
                        'customer_company'=>array(
                            'name'=>'customer_company',
                            'text'=>'str_menu_customer_company',
                            'children'=>array(
                                //客户公司列表
                                'customer_company_list'=>array(
                                    'name'=>'customer_company_list',
                                    'text'=>'str_customer_company_list',
                                    'access'=>array(
                                        array('ctr'=>'Customer','act'=>'customerCompany,companyDetail'),
                                    ),
                                ),
                                
                            ),
                            
                        ),
                        //员工客户
                        'customer_employee'=>array(
                            'name'=>'customer_employee',
                            'text'=>'str_menu_customer_employees_customer',
                            'children'=>array(
                                //数据分配
                                'customer_data_distribution'=>array(
                                    'name'=>'customer_data_distribution',
                                    'text'=>'str_customer_data_distribution',
                                    'access'=>array(
                                        array('ctr'=>'Customer','act'=>'employeesCustomer,getCustomerList'),
                                    ),
                                ),
                                
                            ),
                            
                        ),
                    )
                ),

                
                //企业
                'business'=>array(
                    'name'=>'business',
                    'text'=>'str_business_manage',
                    'children'=>array(
                        //基本信息
                        'basic_info'=>array(
                            'name'=>'basic_info',
                            'text'=>'str_reg_basic_info',
                            'children'=>array(
                                //编辑基本信息
                                'edit_basic_info'=>array(
                                    'name'=>'edit_basic_info',
                                    'text'=>'str_edit_basic_info',
                                    'access'=>array(
                                        array('ctr'=>'CompanyInfo','act'=>'info,saveInfo'),
                                    ),
                                ),
                                
                            ),
                            
                        ),
                        //企业动态
                        'business_movement'=>array(
                            'name'=>'business_movement',
                            'text'=>'str_menu_business_movement',
                            'children'=>array(
                                //企业动态列表
                                'business_movement_list'=>array(
                                    'name'=>'business_movement_list',
                                    'text'=>'str_business_movement_list',
                                    'access'=>array(
                                        array('ctr'=>'CompanyInfo','act'=>'newsList'),
                                    ),
                                ),
                                //新增企业动态
                                'business_movement_add'=>array(
                                    'name'=>'business_movement_add',
                                    'text'=>'str_business_movement_add',
                                    'access'=>array(
                                        array('ctr'=>'CompanyInfo','act'=>'newsPage,doNews'),
                                    ),
                                ),
                                //编辑企业动态
                                'business_movement_edit'=>array(
                                    'name'=>'business_movement_edit',
                                    'text'=>'str_business_movement_edit',
                                    'access'=>array(
                                        array('ctr'=>'CompanyInfo','act'=>'newsPage,doNews'),
                                    ),
                                ),
                                //删除企业动态
                                'business_movement_del'=>array(
                                    'name'=>'business_movement_del',
                                    'text'=>'str_business_movement_del',
                                    'access'=>array(
                                        array('ctr'=>'CompanyInfo','act'=>'delNews'),
                                    ),
                                ),
                                
                            ),
                            
                        ),
                        //企业名片
                        'business_cards'=>array(
                            'name'=>'business_cards',
                            'text'=>'str_menu_business_cards',
                            'children'=>array(
                                //编辑企业名片
                                'business_cards_edit'=>array(
                                    'name'=>'business_cards_edit',
                                    'text'=>'str_business_cards_edit',
                                    'access'=>array(
                                        array('ctr'=>'CompanyInfo','act'=>'saveCard2,uploadImg'),
                                    ),
                                ),
                                
                            ),
                            
                        ),
                    )
                ),


                //系统设置
                'system_set'=>array(
                    'name'=>'system_set',
                    'text'=>'str_system_set',
                    'children'=>array(
                        //设置角色权限
                        'system_set_role'=>array(
                            'name'=>'system_set_role',
                            'text'=>'str_menu_system_set_role',
                            'children'=>array(
                                //角色列表
                                'sys_role_list'=>array(
                                    'name'=>'sys_role_list',
                                    'text'=>'str_sys_role_list',
                                    'access'=>array(
                                        array('ctr'=>'System','act'=>'role,sysSet'),
                                    ),
                                ),
                                //新增编辑角色
                                'sys_role_add_edit'=>array(
                                    'name'=>'sys_role_add_edit',
                                    'text'=>'str_sys_role_add_edit',
                                    'access'=>array(
                                        array('ctr'=>'System','act'=>'sysSet,addRole,setAccessPost,getAccess,getUser'),
                                    ),
                                ),
                                //删除角色
                                'sys_role_del'=>array(
                                    'name'=>'sys_role_del',
                                    'text'=>'str_sys_role_del',
                                    'access'=>array(
                                        array('ctr'=>'System','act'=>'sysSet,delRole'),
                                    ),
                                ),
                            ),
                            
                        ),
                        //修改登录密码
                        'edit_login_pass'=>array(
                            'name'=>'edit_login_pass',
                            'text'=>'str_menu_system_login_passwd',
                            'children'=>array(
                                //修改登录密码
                                'edit_login_pass'=>array(
                                    'name'=>'edit_login_pass',
                                    'text'=>'str_menu_system_login_passwd',
                                    'access'=>array(
                                        array('ctr'=>'System','act'=>'updatePass,passPost'),
                                    ),
                                ),
                                
                            ),
                            
                        ),
                        //更换登录账号
                        'edit_login_account'=>array(
                            'name'=>'edit_login_account',
                            'text'=>'str_menu_system_change_loguser',
                            'children'=>array(
                                //更换登录账号
                                'edit_login_account'=>array(
                                    'name'=>'edit_login_account',
                                    'text'=>'str_menu_system_change_loguser',
                                    'access'=>array(
                                        array('ctr'=>'System','act'=>'updateEmail,emailPost'),
                                    ),
                                ),
                                
                            ),
                            
                        ),
                    )
                ),

         */),
        //模块=>array('text' => "",'children' => array('模块下包含的controller','......')第一个子项controller  为顶级菜单默认访问项
      /*  'Menutocontr'=>array(
                //我的面板
                'mypanel'       => array(
                        'text' => "str_mypanel",
                        'children' => array('Index')
                ),

        ),*/
);
