function v = piecequad(x,y,u)
%
%  v = piecequad(x,y,u) finds the quadratic spline q(x)
%  with q(x(j)) = y(j), q'(x(1)) = dy and q'(x) continuous.
%  returns v(k) = q(u(k)). The slope dy = f(x(1)).

%  Find subinterval indices k so that x(k) <= u < x(k+1)

   n = length(x);
   b = zeros(n);
   c = zeros(n);
   
   dy=2.77; %slope
   
   b(1) = dy;
   h = x(2)-x(1);
   c(1) = (y(2)-y(1)-dy*h)/h^2; 
   
   k = ones(size(u)); %subinterval indices
   for j = 2:n-1
   
%     compute coefficients in quadratic spline
      b(j) = -b(j-1)+2*(y(j)-y(j-1))/(x(j)-x(j-1));
      h = x(j+1)-x(j);
      c(j) = (y(j+1)-y(j)-b(j)*h)/h^2;

%     find sub-intervals where lie points u where to interpolate
      k(x(j) <= u) = j;
   end

%  Evaluate interpolant

   s = u - x(k);
   v = y(k) + b(k).*s + c(k).*s.^2;

   
   



