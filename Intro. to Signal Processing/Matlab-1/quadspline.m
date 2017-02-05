x=[265 400 500 700 950 1360 2080 2450 2940];
y=[1025 1400 1710 2080 2425 2760 3005 2850 2675];


u = 265:10:2950; % values along the x-axis
[m,n] = size(u);
% splinevals stores the quadratic spline values for the u-values
splinevals = zeros(n);
for i = 1:n
	splinevals(i) = piecequad(x,y,u(i));
end
% Plot the x-y data as circles ('o') and the polynomial data as '-'
plot(x,y,'+',u,splinevals,'-')

