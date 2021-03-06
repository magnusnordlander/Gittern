<?php

namespace Gittern\Hydrator;

use Gittern\Entity\GitObject\Commit;
use Gittern\Entity\GitObject\User;

use Gittern\Transport\RawObject;

use Gittern\Repository;

use Gittern\Proxy\TreeProxy;
use Gittern\Proxy\CommitProxy;

/**
* @author Magnus Nordlander
**/
class CommitHydrator implements HydratorInterface
{
  protected $repo;

  public function __construct(Repository $repo)
  {
    $this->repo = $repo;
  }

  public function hydrate(RawObject $raw_object)
  {
    $commit = new Commit();
    $commit->setSha($raw_object->getSha());

    list($meta, $message) = explode("\n\n", $raw_object->getData());

    $commit->setMessage($message);

    foreach(explode("\n", $meta) as $meta_line)
    {
      sscanf($meta_line, "%s ", $attribute);

      $attribute_value = substr($meta_line, strlen($attribute)+1);

      switch($attribute)
      {
        case 'tree':
          $commit->setTree(new TreeProxy($this->repo, $attribute_value));
        break;
        case 'parent':
          $commit->addParent(new CommitProxy($this->repo, $attribute_value));
        break;
        case 'author':
          preg_match('/(.*?) <(.*?)> ([0-9]*)( (.+))?/', $attribute_value, $matches);
          $commit->setAuthor(new User($matches[1], $matches[2]));
          $commit->setAuthorTime(\DateTime::createFromFormat('U O', $matches[3].' '.$matches[5]));
        break;
        case 'committer':
          preg_match('/(.*?) <(.*?)> ([0-9]*)( (.+))?/', $attribute_value, $matches);
          $commit->setCommitter(new User($matches[1], $matches[2]));
          $commit->setCommitTime(\DateTime::createFromFormat('U O', $matches[3].' '.$matches[5]));
        break;
      }
    }

    return $commit;
  }
}