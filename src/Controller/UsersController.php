<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
	/* pagination variable initialization start */

	public $paginate = [
        'limit' => 10,
        'order' => [
            'Articles.title' => 'asc'
        ]
    ];

	/* pagination variable initialisation end  */
    /**
     * Index method
     *
     * @return \Cake\Network\Response|null
     */
    public function index()
    {
        $users = $this->paginate($this->Users);

        $this->set(compact('users'));
        $this->set('_serialize', ['users']);
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }

    /**
     * Add method
     *
     * @return \Cake\Network\Response|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
			$result = $this->Users->save($user);
              
			if ($result) {
				
				/******************************** File upload code starts *****************************************/
				
				$record_id=$result->id; //echo $record_id; exit;

				if(!empty($this->request->data['file']['name'])){

					$fileName  = $this->request->data['file']['name'];
					$uploadPath = 'E:/wamp/www/cakephp326/uploads/files/';
					$uploadFile = $uploadPath.$fileName;
				
					if(move_uploaded_file($this->request->data['file']['tmp_name'],$uploadFile)){
						
						$user_id = $result['id'];

						$users = TableRegistry::get('Users');
						$query = $users->query();
						$response_update = $query->update()
						->set(['photo' =>$uploadFile])
						->where(['id' =>$user_id])
						->execute();

						/*	
						$uploadData = $this->Files->newEntity();
						$uploadData->name = $fileName;
						$uploadData->path = $uploadPath;
						$uploadData->created = date("Y-m-d H:i:s");
						$uploadData->modified = date("Y-m-d H:i:s");
                        
						*/

						if($response_update) {
							$this->Flash->success(__('File has been uploaded and inserted successfully.'));
						}else{
							$this->Flash->error(__('Unable to upload file, please try again.'));
						}

					}else{
						$this->Flash->error(__('Unable to upload file, please try again.'));
					}

				}else{
				
					$this->Flash->error(__('Please choose a file to upload.'));
				
				}




				/******************************* File upload code ends   **************************************/

                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => '/add/']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error(__('The user could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Network\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }

  
	public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);
        // Allow users to register and logout.
        // You should not add the "login" action to allow list. Doing so would
        // cause problems with normal functioning of AuthComponent.
        $this->Auth->allow(['add', 'logout','view']);
    }
	
	

    public function login()
    {
        if($this->request->is('post')) {
            $user = $this->Auth->identify();
            if($user){
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl('/users'));
            }
            $this->Flash->error(__('Invalid username or password, try again'));
        }
    }

    public function logout()
    {
        return $this->redirect($this->Auth->logout());
    }

	/*
	public function changePassword($id = null)
    {

		$user = $this->Users->get($id, [
		'contain' => []
		]);

		if ($this->request->is(['patch', 'post', 'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->data);
			
			if ($this->Users->save($user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(['action' => 'index']);
			
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}

		$this->set(compact('user'));
		$this->set('_serialize', ['user']);


    
	}

	*/


	public function changePassword()
    {
        $user =$this->Users->get($this->Auth->user('id'));  //echo "<pre>"; print_r($user);
        if (!empty($this->request->data)) {
            $user = $this->Users->patchEntity($user, [
                    'old_password'  => $this->request->data['old_password'],
                    'password'      => $this->request->data['password1'],
                    'password1'     => $this->request->data['password1'],
                    'password2'     => $this->request->data['password2']
                ],
                ['validate' => 'password']
            );
            if ($this->Users->save($user)) {
                $this->Flash->success('The password is successfully changed');
                $this->redirect('/users/');
            } else {
                $this->Flash->error('There was an error during the save!......');
            }
        }
        $this->set('user',$user);
    }


}
