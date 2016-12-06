<?php
/**
 * PostController inherits from AppController and is responsible for
 * controlling the actions available in Posts.
 */

class PostsController extends AppController {
  public $helpers = array('Html', 'Form');

  /**
   * index defines the data accessed when either
   * http://localhost/BlogApplication/posts or
   * http://localhost/BlogApplication/posts/index are accessed.
   *
   * This is all of the posts in the blog_posts database.

   * Set passes the data to the index view.
   */
  public function index() {
    $this->Set('posts', $this->Post->find('all'));
  }

  /**
   * view defines the data accessed when the title of a post is
   * selected.
   *
   * It looks only at a single post by using findById.
   *
   * If it does not have a valid id, an exception is thrown.
   *
   * Set passes the data to the view view.
   */

  public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }

        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        $this->set('post', $post);
    }

    /**
     * add defines the actions perforemed when the add post button is
     * selected.
     *
     * It creates a new entry in blog_posts if successful.
     */

    public function add() {
        if ($this->request->is('post')) {
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('Your post has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to add your post.'));
        }
    }

    /**
     * edit defines the actions performed when the edit button is
     * selected.
     *
     * It saves the updated entry in blog_posts if successful.
     */

    public function edit($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $post = $this->Post->findById($id);
        if (!$post) {
            throw new NotFoundException(__('Invalid post'));
        }
        if ($this->request->is(array('post', 'put'))) {
            $this->Post->id = $id;
            if ($this->Post->save($this->request->data)) {
                $this->Flash->success(__('Your post has been updated.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Flash->error(__('Unable to update your post.'));
        }
        if (!$this->request->data) {
            $this->request->data = $post;
        }
    }

    /**
     * delete defines the actions performed when delete button is selected.
     *
     * It does not allow get requests to trigger delete. This is to avoid
     * web crawlers deleting content.
     */

    public function delete($id) {
        if ($this->request->is('get')) {
            throw new MethodNotAllowedException();
        }
        if ($this->Post->delete($id)) {
            $this->Flash->success(
              __('The post with id: %s has been deleted.', h($id)));
        } else {
            $this->Flash->error(
              __('The post with id: %s could not be deleted.', h($id)));
        }
        return $this->redirect(array('action' => 'index'));
    }

}
