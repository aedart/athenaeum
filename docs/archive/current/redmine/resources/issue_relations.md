---
description: Working with issue relations
sidebarDepth: 0
---

# Issue Relations

In this context, an issue relation resource is what defines how an issue is related to one or more issues.
See [Redmine docs.](https://www.redmine.org/projects/redmine/wiki/Rest_IssueRelations) for details.

## Create new relation

The easiest way to relate an issue with another, is by using the `addRelation()` method, in the `Issue` resource.

```php
$issueA = Issue::find(2254);
$issueB = Issue::find(8741);

$relation = $issueA->addRelation($issueA);
```

In the example shown above, issue A is related with issue B. The resulting output of the `addRelation()` method, is a `Relation` resource, containing details about the issue association.

### Specify type of relation

You may also specify the type of the relation, by using the 2nd argument. 

```php
use Aedart\Redmine\Relation;

$issueA = Issue::find(2254);
$issueB = Issue::find(8741);

$relation = $issueA->addRelation($issueA, Relation::DUPLICATES);
```

**Note**: _When type of relation is not specified, then `Relation::RELATES` is used as the default relation type._

### Specify "Delay"

The `Relation::PRECEDES` or `Relation::FOLLOWS` relation types accept an additional "delay" argument.
The 3rd argument can be used for stating the delay in amount of days. 

```php
$relation = $issueA->addRelation($issueA, Relation::FOLLOWS, 2);
```

## Fetch existing relations

To fetch an issue with all of it's relations, you must include "relations", when fetching an issue.

```php
$issue = Issue::findOrFail(1234, [ 'relations'] );

$relations = $issue->relations;

foreach($relations as $relation) {
    echo $relation->relation_type;
}
```

## Delete relation

Once you have obtained a relation, you can simply invoke the `delete()` method to remove the relation between two issues.

```php
$relation->delete();
```