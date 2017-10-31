social-bundle
=============

The Rhapsody Social bundle for Symfony provides a basis for all socially
oriented functionality, from blogs (with comments), to forums, and news feeds,
among other applications. In fact we've supplied several extensible bundles
for implementing some of the aforementioned features, see:

- [`rhapsody-project/forum-bundle`][forum-bundle].


At the core of the Rhapsody Social bundle are three concepts: contexts,
activities, and content.

- ___Social Context.___ The social context serves as a taxonomic container, a
contract that describes and classifies the type of content associated with it.
A forum is an example of a social context.
- ___Content.___ Blog posts, forum topics, status updates, and Tweets are all
examples of _content_. Content is typically linked to a social context, but it
needn't be. Some content, such as: links, videos, images, media, etc. exists
independent of social context. 
- ___Activity.___ An activity represents an action taken by a user or an actor
within the system, outside of a social context, that can be used to link back
to the content. In addition to content, an activity can have its own text to
provide a context to the content that is being shared. Activities may also be
interacted with, users can endorse an activity (e.g. "liking" it or "favoriting"
it) and comment on the activity. A user may also control the privacy of some or
all of his activities.

There are several common operations in social media:

- Creating original content (status updates, blog posts, videos, etc.)
- Sharing content
- Endorsing content  
- Commenting on content


## Getting Started


### Configuration

```
rhapsody_social:
    db_driver: odm
    activity_class: Rhapsody\SocialBundle\Entity\Activity
    activity_manager_name: 
```



[forum-bundle]: https://github.com/rhapsody-project/forum-bundle "Rhapsody Forum"