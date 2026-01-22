# KonterCMS API Documentation

## Base URL
```
http://your-domain.com/api/v1
```

## Response Format
All API responses follow this standard format:

```json
{
  "success": true,
  "data": {},
  "message": "Optional message",
  "pagination": {} // Only for paginated responses
}
```

## Error Response Format
```json
{
  "success": false,
  "message": "Error message",
  "errors": {} // Validation errors (optional)
}
```

---

## Posts API

### Get All Posts
**GET** `/posts`

**Parameters:**
- `category` (string, optional) - Filter by category slug
- `tag` (string, optional) - Filter by tag slug  
- `search` (string, optional) - Search in title, excerpt, content
- `per_page` (integer, optional) - Items per page (default: 10)
- `page` (integer, optional) - Page number

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Post Title",
      "slug": "post-title",
      "excerpt": "Post excerpt...",
      "content": "Full post content...",
      "featured_image": "image-url",
      "status": "published",
      "is_featured": true,
      "published_at": "2024-01-01T00:00:00.000000Z",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z",
      "user": {
        "id": 1,
        "name": "Author Name"
      },
      "category": {
        "id": 1,
        "name": "Category Name",
        "slug": "category-slug",
        "color": "#3b82f6"
      },
      "tags": [
        {
          "id": 1,
          "name": "Tag Name",
          "slug": "tag-slug",
          "color": "#10b981"
        }
      ]
    }
  ],
  "pagination": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 10,
    "total": 50,
    "from": 1,
    "to": 10,
    "has_more": true,
    "has_previous": false,
    "next_page_url": "http://your-domain.com/api/v1/posts?page=2",
    "prev_page_url": null,
    "first_page_url": "http://your-domain.com/api/v1/posts?page=1",
    "last_page_url": "http://your-domain.com/api/v1/posts?page=5",
    "links": [
      {
        "url": "http://your-domain.com/api/v1/posts?page=1",
        "label": "1",
        "active": true
      },
      {
        "url": "http://your-domain.com/api/v1/posts?page=2",
        "label": "2",
        "active": false
      },
      {
        "url": "http://your-domain.com/api/v1/posts?page=3",
        "label": "3",
        "active": false
      },
      {
        "url": null,
        "label": "...",
        "active": false
      },
      {
        "url": "http://your-domain.com/api/v1/posts?page=5",
        "label": "5",
        "active": false
      }
    ]
  }
}
```

### Get Featured Posts
**GET** `/posts/featured`

**Response:**
```json
{
  "success": true,
  "data": [
    // Array of featured posts (max 6)
  ]
}
```

### Get Latest Posts
**GET** `/posts/latest`

**Parameters:**
- `limit` (integer, optional) - Number of posts (default: 5)

**Response:**
```json
{
  "success": true,
  "data": [
    // Array of latest posts
  ]
}
```

### Search Posts
**GET** `/posts/search`

**Parameters:**
- `q` (string, required) - Search query

**Response:**
```json
{
  "success": true,
  "data": [
    // Array of matching posts (max 20)
  ],
  "query": "search term",
  "total": 5
}
```

### Get Posts for Infinite Scroll
**GET** `/posts/infinite`

**Parameters:**
- `page` (integer, optional) - Page number (default: 1)
- `per_page` (integer, optional) - Items per page (default: 10)
- `category` (string, optional) - Filter by category slug
- `tag` (string, optional) - Filter by tag slug
- `search` (string, optional) - Search query

**Response:**
```json
{
  "success": true,
  "data": [
    // Array of posts
  ],
  "has_more": true,
  "current_page": 1,
  "total": 50
}
```

### Get Single Post
**GET** `/posts/{slug}`

**Response:**
```json
{
  "success": true,
  "data": {
    // Single post object with full details
  },
  "related_posts": [
    // Array of related posts (max 4)
  ]
}
```

---

## Pages API

### Get All Pages
**GET** `/pages`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Page Title",
      "slug": "page-slug",
      "excerpt": "Page excerpt...",
      "content": "Full page content...",
      "template": "default",
      "status": "published",
      "sort_order": 0,
      "show_in_menu": true,
      "is_homepage": false,
      "meta_title": "SEO Title",
      "meta_description": "SEO Description",
      "meta_keywords": "keywords",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z",
      "user": {
        "id": 1,
        "name": "Author Name"
      }
    }
  ]
}
```

### Get Homepage
**GET** `/pages/homepage`

**Response:**
```json
{
  "success": true,
  "data": {
    // Homepage page object
  }
}
```

### Get Menu Pages
**GET** `/pages/menu`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "title": "Page Title",
      "slug": "page-slug"
    }
  ]
}
```

### Get Single Page
**GET** `/pages/{slug}`

**Response:**
```json
{
  "success": true,
  "data": {
    // Single page object with full details
  }
}
```

---

## Categories API

### Get All Categories
**GET** `/categories`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Category Name",
      "slug": "category-slug",
      "description": "Category description...",
      "color": "#3b82f6",
      "meta_title": "SEO Title",
      "meta_description": "SEO Description",
      "posts_count": 15,
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

### Get Single Category
**GET** `/categories/{slug}`

**Response:**
```json
{
  "success": true,
  "data": {
    // Single category object with posts count
  }
}
```

### Get Category Posts
**GET** `/categories/{slug}/posts`

**Parameters:**
- `per_page` (integer, optional) - Items per page (default: 10)
- `page` (integer, optional) - Page number

**Response:**
```json
{
  "success": true,
  "category": {
    // Category object
  },
  "data": [
    // Array of posts in this category
  ],
  "pagination": {
    // Pagination info
  }
}
```

---

## Tags API

### Get All Tags
**GET** `/tags`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Tag Name",
      "slug": "tag-slug",
      "description": "Tag description...",
      "color": "#10b981",
      "posts_count": 8,
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z"
    }
  ]
}
```

### Get Popular Tags
**GET** `/tags/popular`

**Parameters:**
- `limit` (integer, optional) - Number of tags (default: 10)

**Response:**
```json
{
  "success": true,
  "data": [
    // Array of popular tags ordered by posts count
  ]
}
```

### Get Single Tag
**GET** `/tags/{slug}`

**Response:**
```json
{
  "success": true,
  "data": {
    // Single tag object with posts count
  }
}
```

### Get Tag Posts
**GET** `/tags/{slug}/posts`

**Parameters:**
- `per_page` (integer, optional) - Items per page (default: 10)
- `page` (integer, optional) - Page number

**Response:**
```json
{
  "success": true,
  "tag": {
    // Tag object
  },
  "data": [
    // Array of posts with this tag
  ],
  "pagination": {
    // Pagination info
  }
}
```

---

## Menus API

### Get All Menus
**GET** `/menus`

**Response:**
```json
{
  "success": true,
  "data": [
    {
      "id": 1,
      "name": "Main Navigation",
      "slug": "main-navigation",
      "description": "Main website navigation",
      "created_at": "2024-01-01T00:00:00.000000Z",
      "updated_at": "2024-01-01T00:00:00.000000Z",
      "items": [
        {
          "id": 1,
          "title": "Home",
          "url": "/",
          "target": "_self",
          "sort_order": 0,
          "parent_id": null,
          "children": [
            {
              "id": 2,
              "title": "Submenu Item",
              "url": "/submenu",
              "target": "_self",
              "sort_order": 0,
              "parent_id": 1
            }
          ]
        }
      ]
    }
  ]
}
```

### Get Navigation Menu
**GET** `/menus/navigation`

**Response:**
```json
{
  "success": true,
  "data": {
    // Main navigation menu with nested items
  }
}
```

### Get Footer Menu
**GET** `/menus/footer`

**Response:**
```json
{
  "success": true,
  "data": {
    // Footer menu with nested items
  }
}
```

### Get Single Menu
**GET** `/menus/{slug}`

**Response:**
```json
{
  "success": true,
  "data": {
    // Single menu object with nested items
  }
}
```

---

## Settings API

### Get All Public Settings
**GET** `/settings`

**Response:**
```json
{
  "success": true,
  "data": {
    "site_name": "KonterCMS",
    "site_tagline": "Modern CMS Solution",
    "site_description": "A powerful content management system",
    "contact_email": "info@example.com",
    "contact_phone": "+1234567890",
    // ... other public settings (sensitive settings excluded)
  }
}
```

### Get General Settings
**GET** `/settings/general`

**Response:**
```json
{
  "success": true,
  "data": {
    "site_name": "KonterCMS",
    "site_tagline": "Modern CMS Solution",
    "site_description": "A powerful content management system",
    "site_logo": "/storage/logo.png",
    "site_favicon": "/storage/favicon.ico",
    "contact_email": "info@example.com",
    "contact_phone": "+1234567890",
    "contact_address": "123 Main St, City, Country",
    "timezone": "UTC",
    "date_format": "Y-m-d",
    "time_format": "H:i:s"
  }
}
```

### Get SEO Settings
**GET** `/settings/seo`

**Response:**
```json
{
  "success": true,
  "data": {
    "meta_title": "KonterCMS - Modern CMS Solution",
    "meta_description": "A powerful and flexible content management system",
    "meta_keywords": "cms, content management, laravel",
    "og_title": "KonterCMS",
    "og_description": "Modern CMS Solution",
    "og_image": "/storage/og-image.jpg",
    "twitter_card": "summary_large_image",
    "twitter_site": "@kontercms",
    "twitter_creator": "@kontercms"
  }
}
```

### Get Social Media Settings
**GET** `/settings/social`

**Response:**
```json
{
  "success": true,
  "data": {
    "facebook_url": "https://facebook.com/kontercms",
    "twitter_url": "https://twitter.com/kontercms",
    "instagram_url": "https://instagram.com/kontercms",
    "linkedin_url": "https://linkedin.com/company/kontercms",
    "youtube_url": "https://youtube.com/kontercms",
    "tiktok_url": "https://tiktok.com/@kontercms",
    "whatsapp_number": "+1234567890"
  }
}
```

### Get Company Settings
**GET** `/settings/company`

**Response:**
```json
{
  "success": true,
  "data": {
    "company_name": "KonterCMS Inc.",
    "company_tagline": "Modern CMS Solutions",
    "company_description": "We provide powerful CMS solutions",
    "company_about": "About our company...",
    "company_vision": "Our vision statement...",
    "company_mission": "Our mission statement...",
    "company_address": "123 Business St, City, Country",
    "company_phone": "+1234567890",
    "company_email": "info@kontercms.com",
    "company_whatsapp": "+1234567890",
    "company_telegram": "@kontercms",
    "telegram_channel": "@kontercms_channel",
    "cta_title": "Ready to Start?",
    "cta_subtitle": "Join thousands of satisfied customers",
    "cta_description": "Get started with our amazing platform today",
    "cta_button_text": "Get Started",
    "cta_button_url": "https://example.com/signup",
    "cta_whatsapp_number": "+1234567890",
    "cta_whatsapp_message": "Hi, I'm interested in your services"
  }
}
```

### Get Single Setting
**GET** `/settings/{key}`

**Response:**
```json
{
  "success": true,
  "data": {
    "key": "site_name",
    "value": "KonterCMS"
  }
}
```

---

## Sitemap API

### Get Sitemap Data
**GET** `/sitemap`

Returns all content URLs for sitemap generation.

**Response:**
```json
{
  "success": true,
  "data": {
    "posts": [
      {
        "slug": "post-slug",
        "updated_at": "2024-01-01T00:00:00.000000Z"
      }
    ],
    "pages": [
      {
        "slug": "page-slug", 
        "updated_at": "2024-01-01T00:00:00.000000Z"
      }
    ],
    "categories": [
      {
        "slug": "category-slug",
        "updated_at": "2024-01-01T00:00:00.000000Z"
      }
    ],
    "tags": [
      {
        "slug": "tag-slug",
        "updated_at": "2024-01-01T00:00:00.000000Z"
      }
    ]
  }
}
```

---

## Error Codes

- **200** - Success
- **404** - Resource not found
- **403** - Access denied (for sensitive settings)
- **422** - Validation error
- **500** - Server error

---

## Usage Examples

### Next.js Integration

```javascript
// lib/api.js
const API_BASE_URL = 'http://your-domain.com/api/v1';

export const api = {
  // Get posts
  async getPosts(params = {}) {
    const query = new URLSearchParams(params).toString();
    const response = await fetch(`${API_BASE_URL}/posts?${query}`);
    return response.json();
  },

  // Get single post
  async getPost(slug) {
    const response = await fetch(`${API_BASE_URL}/posts/${slug}`);
    return response.json();
  },

  // Search posts
  async searchPosts(query) {
    const response = await fetch(`${API_BASE_URL}/posts/search?q=${encodeURIComponent(query)}`);
    return response.json();
  },

  // Get categories
  async getCategories() {
    const response = await fetch(`${API_BASE_URL}/categories`);
    return response.json();
  },

  // Get category posts
  async getCategoryPosts(slug, params = {}) {
    const query = new URLSearchParams(params).toString();
    const response = await fetch(`${API_BASE_URL}/categories/${slug}/posts?${query}`);
    return response.json();
  },

  // Get settings
  async getSettings(group = '') {
    const url = group ? `${API_BASE_URL}/settings/${group}` : `${API_BASE_URL}/settings`;
    const response = await fetch(url);
    return response.json();
  },

  // Get navigation menu
  async getNavigation() {
    const response = await fetch(`${API_BASE_URL}/menus/navigation`);
    return response.json();
  },

  // Get sitemap data
  async getSitemap() {
    const response = await fetch(`${API_BASE_URL}/sitemap`);
    return response.json();
  },

  // Get posts for infinite scroll
  async getPostsInfinite(params = {}) {
    const query = new URLSearchParams(params).toString();
    const response = await fetch(`${API_BASE_URL}/posts/infinite?${query}`);
    return response.json();
  }
};
```

### Next.js Pages Example

```jsx
// pages/index.js - Homepage
import { useState, useEffect } from 'react';
import { api } from '../lib/api';

export default function Home({ posts, settings }) {
  return (
    <div>
      <h1>{settings.site_name}</h1>
      <p>{settings.site_tagline}</p>
      
      <div className="posts-grid">
        {posts.map(post => (
          <article key={post.id}>
            <h2>{post.title}</h2>
            <p>{post.excerpt}</p>
            {post.category && (
              <span className="category">{post.category.name}</span>
            )}
          </article>
        ))}
      </div>
    </div>
  );
}

export async function getStaticProps() {
  const [postsResponse, settingsResponse] = await Promise.all([
    api.getPosts({ per_page: 6 }),
    api.getSettings('general')
  ]);

  return {
    props: {
      posts: postsResponse.success ? postsResponse.data : [],
      settings: settingsResponse.success ? settingsResponse.data : {}
    },
    revalidate: 60 // Revalidate every minute
  };
}
```

```jsx
// pages/posts/[slug].js - Single Post
import { api } from '../../lib/api';

export default function Post({ post, relatedPosts }) {
  if (!post) return <div>Post not found</div>;

  return (
    <article>
      <h1>{post.title}</h1>
      <div dangerouslySetInnerHTML={{ __html: post.content }} />
      
      {relatedPosts.length > 0 && (
        <section>
          <h3>Related Posts</h3>
          {relatedPosts.map(related => (
            <div key={related.id}>
              <h4>{related.title}</h4>
            </div>
          ))}
        </section>
      )}
    </article>
  );
}

export async function getStaticPaths() {
  // For now, return empty paths to generate on-demand
  return {
    paths: [],
    fallback: 'blocking'
  };
}

export async function getStaticProps({ params }) {
  const response = await api.getPost(params.slug);
  
  if (!response.success) {
    return { notFound: true };
  }

  return {
    props: {
      post: response.data,
      relatedPosts: response.related_posts || []
    },
    revalidate: 60
  };
}
```

```jsx
// pages/search.js - Search Page
import { useState, useEffect } from 'react';
import { useRouter } from 'next/router';
import { api } from '../lib/api';

export default function Search() {
  const router = useRouter();
  const [query, setQuery] = useState(router.query.q || '');
  const [results, setResults] = useState([]);
  const [loading, setLoading] = useState(false);

  const handleSearch = async (searchQuery) => {
    if (!searchQuery.trim()) return;
    
    setLoading(true);
    try {
      const response = await api.searchPosts(searchQuery);
      if (response.success) {
        setResults(response.data);
      }
    } catch (error) {
      console.error('Search error:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    if (router.query.q) {
      handleSearch(router.query.q);
    }
  }, [router.query.q]);

  return (
    <div>
      <h1>Search</h1>
      <input
        type="text"
        value={query}
        onChange={(e) => setQuery(e.target.value)}
        onKeyPress={(e) => e.key === 'Enter' && handleSearch(query)}
        placeholder="Search posts..."
      />
      
      {loading && <div>Searching...</div>}
      
      <div className="search-results">
        {results.map(post => (
          <article key={post.id}>
            <h2>{post.title}</h2>
            <p>{post.excerpt}</p>
          </article>
        ))}
      </div>
    </div>
  );
}
```

### React Component Example

```jsx
// components/PostList.jsx
import { useState, useEffect } from 'react';
import { api } from '../lib/api';

export default function PostList() {
  const [posts, setPosts] = useState([]);
  const [pagination, setPagination] = useState(null);
  const [loading, setLoading] = useState(true);
  const [currentPage, setCurrentPage] = useState(1);

  const fetchPosts = async (page = 1) => {
    setLoading(true);
    try {
      const response = await api.getPosts({ 
        per_page: 6, 
        page: page 
      });
      if (response.success) {
        setPosts(response.data);
        setPagination(response.pagination);
        setCurrentPage(page);
      }
    } catch (error) {
      console.error('Error fetching posts:', error);
    } finally {
      setLoading(false);
    }
  };

  useEffect(() => {
    fetchPosts(currentPage);
  }, []);

  const handlePageChange = (page) => {
    if (page !== currentPage && page >= 1 && page <= pagination?.last_page) {
      fetchPosts(page);
      // Scroll to top
      window.scrollTo({ top: 0, behavior: 'smooth' });
    }
  };

  if (loading) return <div>Loading...</div>;

  return (
    <div>
      {/* Posts Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {posts.map(post => (
          <article key={post.id} className="bg-white rounded-lg shadow-md overflow-hidden">
            {post.featured_image && (
              <img 
                src={post.featured_image} 
                alt={post.title}
                className="w-full h-48 object-cover"
              />
            )}
            <div className="p-6">
              <h2 className="text-xl font-bold mb-2">{post.title}</h2>
              <p className="text-gray-600 mb-4">{post.excerpt}</p>
              {post.category && (
                <span 
                  className="inline-block px-2 py-1 text-xs rounded-full mb-4"
                  style={{ 
                    backgroundColor: post.category.color + '20', 
                    color: post.category.color 
                  }}
                >
                  {post.category.name}
                </span>
              )}
              <a 
                href={`/posts/${post.slug}`}
                className="text-blue-600 hover:text-blue-800 font-medium"
              >
                Read More →
              </a>
            </div>
          </article>
        ))}
      </div>

      {/* Pagination */}
      {pagination && pagination.last_page > 1 && (
        <div className="flex justify-center items-center space-x-2">
          {/* Previous Button */}
          <button
            onClick={() => handlePageChange(currentPage - 1)}
            disabled={!pagination.has_previous}
            className={`px-3 py-2 rounded-md ${
              pagination.has_previous
                ? 'bg-blue-500 text-white hover:bg-blue-600'
                : 'bg-gray-300 text-gray-500 cursor-not-allowed'
            }`}
          >
            Previous
          </button>

          {/* Page Numbers */}
          {pagination.links?.map((link, index) => (
            <button
              key={index}
              onClick={() => link.url && handlePageChange(parseInt(link.label))}
              disabled={!link.url || link.active}
              className={`px-3 py-2 rounded-md ${
                link.active
                  ? 'bg-blue-600 text-white'
                  : link.url
                  ? 'bg-white text-blue-600 border border-blue-600 hover:bg-blue-50'
                  : 'text-gray-400 cursor-default'
              }`}
            >
              {link.label}
            </button>
          ))}

          {/* Next Button */}
          <button
            onClick={() => handlePageChange(currentPage + 1)}
            disabled={!pagination.has_more}
            className={`px-3 py-2 rounded-md ${
              pagination.has_more
                ? 'bg-blue-500 text-white hover:bg-blue-600'
                : 'bg-gray-300 text-gray-500 cursor-not-allowed'
            }`}
          >
            Next
          </button>
        </div>
      )}

      {/* Pagination Info */}
      {pagination && (
        <div className="text-center text-gray-600 mt-4">
          Showing {pagination.from} to {pagination.to} of {pagination.total} posts
        </div>
      )}
    </div>
  );
}
```

### Advanced Pagination Hook

```jsx
// hooks/usePagination.js
import { useState, useEffect } from 'react';

export function usePagination(fetchFunction, initialParams = {}) {
  const [data, setData] = useState([]);
  const [pagination, setPagination] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [params, setParams] = useState(initialParams);

  const fetchData = async (newParams = {}) => {
    setLoading(true);
    setError(null);
    
    try {
      const response = await fetchFunction({ ...params, ...newParams });
      if (response.success) {
        setData(response.data);
        setPagination(response.pagination);
      } else {
        setError(response.message || 'Failed to fetch data');
      }
    } catch (err) {
      setError(err.message || 'An error occurred');
    } finally {
      setLoading(false);
    }
  };

  const goToPage = (page) => {
    if (page >= 1 && page <= pagination?.last_page) {
      const newParams = { ...params, page };
      setParams(newParams);
      fetchData(newParams);
    }
  };

  const nextPage = () => {
    if (pagination?.has_more) {
      goToPage(pagination.current_page + 1);
    }
  };

  const prevPage = () => {
    if (pagination?.has_previous) {
      goToPage(pagination.current_page - 1);
    }
  };

  const changePerPage = (perPage) => {
    const newParams = { ...params, per_page: perPage, page: 1 };
    setParams(newParams);
    fetchData(newParams);
  };

  useEffect(() => {
    fetchData();
  }, []);

  return {
    data,
    pagination,
    loading,
    error,
    goToPage,
    nextPage,
    prevPage,
    changePerPage,
    refresh: () => fetchData(params)
  };
}
```

### Using the Pagination Hook

```jsx
// pages/posts.js
import { usePagination } from '../hooks/usePagination';
import { api } from '../lib/api';

export default function PostsPage() {
  const {
    data: posts,
    pagination,
    loading,
    error,
    goToPage,
    nextPage,
    prevPage,
    changePerPage
  } = usePagination(api.getPosts, { per_page: 12 });

  if (loading) return <div>Loading posts...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div className="container mx-auto px-4 py-8">
      <h1 className="text-3xl font-bold mb-8">All Posts</h1>
      
      {/* Per Page Selector */}
      <div className="mb-6">
        <label className="mr-2">Posts per page:</label>
        <select 
          value={pagination?.per_page || 12}
          onChange={(e) => changePerPage(parseInt(e.target.value))}
          className="border rounded px-2 py-1"
        >
          <option value={6}>6</option>
          <option value={12}>12</option>
          <option value={24}>24</option>
          <option value={48}>48</option>
        </select>
      </div>

      {/* Posts Grid */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        {posts.map(post => (
          <div key={post.id} className="bg-white rounded-lg shadow-md p-4">
            <h3 className="font-bold mb-2">{post.title}</h3>
            <p className="text-gray-600 text-sm">{post.excerpt}</p>
          </div>
        ))}
      </div>

      {/* Simple Pagination */}
      {pagination && (
        <div className="flex justify-between items-center">
          <button
            onClick={prevPage}
            disabled={!pagination.has_previous}
            className="px-4 py-2 bg-blue-500 text-white rounded disabled:bg-gray-300"
          >
            Previous
          </button>
          
          <span>
            Page {pagination.current_page} of {pagination.last_page}
          </span>
          
          <button
            onClick={nextPage}
            disabled={!pagination.has_more}
            className="px-4 py-2 bg-blue-500 text-white rounded disabled:bg-gray-300"
          >
            Next
          </button>
        </div>
      )}
    </div>
  );
}
```

---

## Rate Limiting

The API implements rate limiting to prevent abuse:
- **60 requests per minute** for unauthenticated requests
- **1000 requests per minute** for authenticated requests

Rate limit headers are included in responses:
- `X-RateLimit-Limit` - Request limit per minute
- `X-RateLimit-Remaining` - Remaining requests
- `X-RateLimit-Reset` - Reset time (Unix timestamp)

---

## CORS

The API supports Cross-Origin Resource Sharing (CORS) for web applications. Make sure to configure your allowed origins in the Laravel CORS configuration.

---

## Support

For API support and questions, please contact: support@kontercms.com

---

## Infinite Scroll Example

```jsx
// components/InfinitePostList.jsx
import { useState, useEffect, useCallback } from 'react';
import { api } from '../lib/api';

export default function InfinitePostList() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(false);
  const [hasMore, setHasMore] = useState(true);
  const [page, setPage] = useState(1);

  const loadPosts = useCallback(async (pageNum = 1, reset = false) => {
    if (loading) return;
    
    setLoading(true);
    try {
      const response = await api.getPostsInfinite({
        page: pageNum,
        per_page: 12
      });
      
      if (response.success) {
        setPosts(prev => reset ? response.data : [...prev, ...response.data]);
        setHasMore(response.has_more);
        setPage(pageNum);
      }
    } catch (err) {
      console.error('Error loading posts:', err);
    } finally {
      setLoading(false);
    }
  }, [loading]);

  useEffect(() => {
    loadPosts(1, true);
  }, []);

  // Auto-load more when scrolling near bottom
  useEffect(() => {
    const handleScroll = () => {
      if (
        window.innerHeight + document.documentElement.scrollTop
        >= document.documentElement.offsetHeight - 1000 &&
        hasMore && !loading
      ) {
        loadPosts(page + 1);
      }
    };

    window.addEventListener('scroll', handleScroll);
    return () => window.removeEventListener('scroll', handleScroll);
  }, [hasMore, loading, page, loadPosts]);

  return (
    <div>
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        {posts.map((post, index) => (
          <article key={`${post.id}-${index}`} className="bg-white rounded-lg shadow-md p-4">
            <h3 className="font-bold mb-2">{post.title}</h3>
            <p className="text-gray-600 text-sm">{post.excerpt}</p>
          </article>
        ))}
      </div>

      {loading && (
        <div className="text-center py-8">
          <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
        </div>
      )}

      {!hasMore && posts.length > 0 && (
        <div className="text-center py-8 text-gray-600">
          No more posts to load.
        </div>
      )}
    </div>
  );
}
```