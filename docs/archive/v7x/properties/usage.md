---
title: Usage
description: When to use Properties Overloading
---

## When to use this

Generally speaking, magic methods can be very troublesome to use.
For the most part, they prohibit the usage of auto-completion in IDEs and if not documented, developers are forced to read large sections of the source code, in order to gain understanding of what’s going on. Depending upon implementation, there might not be any validation, when dynamically assigning new properties to objects.
This can break dependent components.
In addition to this, it can also be very difficult to write tests for components that are using such magic methods.

This package will not be able to solve any of the mentioned problems, because at the end of the day, as a developer, you still have to ensure that the code readable / understandable, testable and documented.
Therefore, it is recommend that this component is only used if the following are true;

-	Properties should not be allowed to be dynamically created and assigned to an object, without prior knowledge about them. Thus, properties must always be predefined.
-	Getters and setters must always be used for reading / writing properties
-	You wish to allow access to an object’s properties, yet still enforce some kind of control mechanism
