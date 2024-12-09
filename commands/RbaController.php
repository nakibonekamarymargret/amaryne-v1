<?php
namespace app\commands;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
public function actionInit()
{
$auth = Yii::$app->authManager;
$auth->removeAll();

$createSalon = $auth->createPermission('createSalon');
$createSalon->description = 'Create a salon';
$auth->add($createSalon);
$customerRole = $auth->createRole('customer');
$auth->add($customerRole);

// Add "updateSalon" permission
$updateSalon = $auth->createPermission('updateSalon');
$updateSalon->description = 'Update salon';
$auth->add($updateSalon);

// Add "deleteSalon" permission
$deleteSalon = $auth->createPermission('deleteSalon');
$deleteSalon->description = 'Delete salon';
$auth->add($deleteSalon);

// Add "viewSalon" permission
$viewSalon = $auth->createPermission('viewSalon');
$viewSalon->description = 'View salon';
$auth->add($viewSalon);

// Add "manageUsers" permission (for Admin to manage users)
$manageUsers = $auth->createPermission('manageUsers');
$manageUsers->description = 'Manage users';
$auth->add($manageUsers);

// Add "makeAppointment" permission (for Customer to make appointments)
$makeAppointment = $auth->createPermission('makeAppointment');
$makeAppointment->description = 'Make an appointment';
$auth->add($makeAppointment);

// Create "Salon Owner" role and assign permissions
$salonOwner = $auth->createRole('salonOwner');
$auth->add($salonOwner);
$auth->addChild($salonOwner, $createSalon);
$auth->addChild($salonOwner, $updateSalon);

// Create "Admin" role and assign permissions
$admin = $auth->createRole('admin');
$auth->add($admin);
$auth->addChild($admin, $manageUsers); // Admin can manage users
$auth->addChild($admin, $createSalon);
$auth->addChild($admin, $updateSalon);
$auth->addChild($admin, $deleteSalon);
$auth->addChild($admin, $salonOwner); // Admin inherits salon owner permissions

// Create "Customer" role and assign permissions
$customer = $auth->createRole('customer');
$auth->add($customer);
$auth->addChild($customer, $viewSalon); // Customers can only view salons
$auth->addChild($customer, $makeAppointment); // Customers can make appointments

// Assign roles to users (example user IDs, adjust as needed)
$auth->assign($salonOwner, 2); // Assign salon owner role to user with ID 2
$auth->assign($admin, 1); // Assign admin role to user with ID 1
$auth->assign($customer, 3); // Assign customer role to user with ID 3
}
}