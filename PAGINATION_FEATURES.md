# Enhanced Pagination Features for Next.js

## 🎯 Overview

API telah ditingkatkan dengan fitur pagination yang lengkap dan optimized untuk Next.js, termasuk dukungan untuk traditional pagination dan infinite scroll.

## ✨ New Features Added

### 1. Enhanced Pagination Response
```json
{
  "success": true,
  "data": [...],
  "pagination": {
    "current_page": 1,
    "last_page": 5,
    "per_page": 10,
    "total": 50,
    "from": 1,
    "to": 10,
    "has_more": true,
    "has_previous": false,
    "next_page_url": "http://domain.com/api/v1/posts?page=2",
    "prev_page_url": null,
    "first_page_url": "http://domain.com/api/v1/posts?page=1",
    "last_page_url": "http://domain.com/api/v1/posts?page=5",
    "links": [
      {"url": "http://domain.com/api/v1/posts?page=1", "label": "1", "active": true},
      {"url": "http://domain.com/api/v1/posts?page=2", "label": "2", "active": false},
      {"url": null, "label": "...", "active": false},
      {"url": "http://domain.com/api/v1/posts?page=5", "label": "5", "active": false}
    ]
  }
}
```

### 2. Infinite Scroll Endpoint
**New Route**: `GET /api/v1/posts/infinite`

Optimized response for infinite scroll:
```json
{
  "success": true,
  "data": [...],
  "has_more": true,
  "current_page": 1,
  "total": 50
}
```

### 3. Smart Pagination Links
- Automatic ellipsis (...) for large page counts
- Always shows first and last page
- Shows 2 pages before and after current page
- Optimized for UI components

## 🚀 Next.js Integration Examples

### Traditional Pagination Component
```jsx
// components/PaginatedPosts.jsx
import { useState, useEffect } from 'react';
import { api } from '../lib/api';

export default function PaginatedPosts() {
  const [posts, setPosts] = useState([]);
  const [pagination, setPagination] = useState(null);
  const [loading, setLoading] = useState(true);

  const fetchPosts = async (page = 1) => {
    setLoading(true);
    const response = await api.getPosts({ page, per_page: 12 });
    if (response.success) {
      setPosts(response.data);
      setPagination(response.pagination);
    }
    setLoading(false);
  };

  useEffect(() => {
    fetchPosts();
  }, []);

  return (
    <div>
      {/* Posts Grid */}
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {posts.map(post => (
          <div key={post.id} className="bg-white rounded-lg shadow p-4">
            <h3 className="font-bold">{post.title}</h3>
            <p className="text-gray-600">{post.excerpt}</p>
          </div>
        ))}
      </div>

      {/* Pagination */}
      {pagination && (
        <div className="flex justify-center space-x-2">
          {pagination.links.map((link, index) => (
            <button
              key={index}
              onClick={() => link.url && fetchPosts(parseInt(link.label))}
              disabled={!link.url || link.active}
              className={`px-3 py-2 rounded ${
                link.active ? 'bg-blue-600 text-white' : 'bg-gray-200'
              }`}
            >
              {link.label}
            </button>
          ))}
        </div>
      )}
    </div>
  );
}
```

### Infinite Scroll Component
```jsx
// components/InfiniteScrollPosts.jsx
import { useState, useEffect } from 'react';
import { api } from '../lib/api';

export default function InfiniteScrollPosts() {
  const [posts, setPosts] = useState([]);
  const [loading, setLoading] = useState(false);
  const [hasMore, setHasMore] = useState(true);
  const [page, setPage] = useState(1);

  const loadPosts = async (pageNum = 1, reset = false) => {
    if (loading) return;
    
    setLoading(true);
    const response = await api.getPostsInfinite({
      page: pageNum,
      per_page: 12
    });
    
    if (response.success) {
      setPosts(prev => reset ? response.data : [...prev, ...response.data]);
      setHasMore(response.has_more);
      setPage(pageNum);
    }
    setLoading(false);
  };

  useEffect(() => {
    loadPosts(1, true);
  }, []);

  // Auto-load on scroll
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
  }, [hasMore, loading, page]);

  return (
    <div>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {posts.map((post, index) => (
          <div key={`${post.id}-${index}`} className="bg-white rounded-lg shadow p-4">
            <h3 className="font-bold">{post.title}</h3>
            <p className="text-gray-600">{post.excerpt}</p>
          </div>
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

### Custom Pagination Hook
```jsx
// hooks/usePagination.js
import { useState, useEffect } from 'react';

export function usePagination(fetchFunction, initialParams = {}) {
  const [data, setData] = useState([]);
  const [pagination, setPagination] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  const fetchData = async (params = {}) => {
    setLoading(true);
    setError(null);
    
    try {
      const response = await fetchFunction({ ...initialParams, ...params });
      if (response.success) {
        setData(response.data);
        setPagination(response.pagination);
      } else {
        setError(response.message);
      }
    } catch (err) {
      setError(err.message);
    } finally {
      setLoading(false);
    }
  };

  const goToPage = (page) => {
    fetchData({ page });
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
    refresh: () => fetchData()
  };
}
```

## 📊 Performance Benefits

### Traditional Pagination
- **Predictable Loading**: Users know exactly how many pages exist
- **SEO Friendly**: Each page has a unique URL
- **Memory Efficient**: Only loads current page data
- **Navigation Control**: Users can jump to any page

### Infinite Scroll
- **Mobile Optimized**: Better UX on mobile devices
- **Engagement**: Keeps users scrolling and engaged
- **Minimal Data Transfer**: Only loads what's needed
- **Smooth Experience**: No page reloads or navigation breaks

## 🎛️ API Parameters

### All Paginated Endpoints Support:
- `page` (integer) - Page number (default: 1)
- `per_page` (integer) - Items per page (default: 10, max: 100)
- `category` (string) - Filter by category slug
- `tag` (string) - Filter by tag slug
- `search` (string) - Search query

### Endpoints with Enhanced Pagination:
- `GET /api/v1/posts` - Traditional pagination
- `GET /api/v1/posts/infinite` - Infinite scroll optimized
- `GET /api/v1/categories/{slug}/posts` - Category posts
- `GET /api/v1/tags/{slug}/posts` - Tag posts

## ✅ Implementation Status

- ✅ Enhanced pagination response format
- ✅ Smart pagination links with ellipsis
- ✅ Infinite scroll endpoint
- ✅ Next.js component examples
- ✅ Custom React hooks
- ✅ Performance optimizations
- ✅ Complete documentation
- ✅ All endpoints tested

## 🔧 Usage Tips

1. **Choose the Right Method**:
   - Use traditional pagination for desktop/admin interfaces
   - Use infinite scroll for mobile/social media style feeds

2. **Performance Optimization**:
   - Set reasonable `per_page` limits (12-24 for grids, 5-10 for lists)
   - Implement loading states for better UX
   - Use lazy loading for images

3. **SEO Considerations**:
   - Traditional pagination is better for SEO
   - Infinite scroll needs special handling for search engines

4. **Error Handling**:
   - Always handle loading and error states
   - Provide retry mechanisms for failed requests

The enhanced pagination system is now ready for production use with comprehensive Next.js integration examples!